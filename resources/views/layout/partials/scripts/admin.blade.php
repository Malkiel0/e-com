<!-- Scripts Admin - Gestion Back-office Avancée -->

<!-- Configuration et authentification admin -->
<script>
    // Store administrateur
    window.AdminStore = {
        config: {
            apiEndpoint: '/api/admin',
            refreshInterval: 30000, // 30 secondes
            autoSaveInterval: 5000   // 5 secondes
        },
        
        state: {
            user: @json(auth()->user() ?? null),
            permissions: @json(auth()->user()->permissions ?? []),
            dashboard: {
                stats: {},
                recentOrders: [],
                lowStock: [],
                pendingActions: 0
            },
            notifications: [],
            unsavedChanges: false
        },
        
        // Gestion des statistiques en temps réel
        dashboard: {
            init: function() {
                AdminStore.dashboard.loadStats();
                setInterval(AdminStore.dashboard.refresh, AdminStore.config.refreshInterval);
            },
            
            loadStats: function() {
                fetch(`${AdminStore.config.apiEndpoint}/dashboard-stats`)
                    .then(response => response.json())
                    .then(data => {
                        AdminStore.state.dashboard.stats = data;
                        AdminStore.dashboard.updateUI();
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des statistiques:', error);
                        AdminStore.ui.showNotification('Erreur de connexion', 'error');
                    });
            },
            
            refresh: function() {
                AdminStore.dashboard.loadStats();
                AdminStore.orders.checkNewOrders();
                AdminStore.inventory.checkLowStock();
            },
            
            updateUI: function() {
                const stats = AdminStore.state.dashboard.stats;
                
                // Mise à jour des compteurs
                document.querySelectorAll('[data-stat]').forEach(element => {
                    const statKey = element.dataset.stat;
                    if (stats[statKey] !== undefined) {
                        AdminStore.ui.animateCounter(element, stats[statKey]);
                    }
                });
                
                // Mise à jour des graphiques
                if (window.Chart && stats.chartData) {
                    AdminStore.charts.updateAll(stats.chartData);
                }
            }
        },
        
        // Gestion des commandes
        orders: {
            checkNewOrders: function() {
                fetch(`${AdminStore.config.apiEndpoint}/orders/new`)
                    .then(response => response.json())
                    .then(orders => {
                        if (orders.length > 0) {
                            AdminStore.ui.showNotification(
                                `${orders.length} nouvelle(s) commande(s) reçue(s)`, 
                                'info',
                                {
                                    action: 'Voir',
                                    callback: () => window.location.href = '/admin/orders'
                                }
                            );
                            AdminStore.ui.playNotificationSound();
                        }
                    });
            },
            
            updateStatus: function(orderId, status, notes = '') {
                const data = { status, notes };
                
                fetch(`${AdminStore.config.apiEndpoint}/orders/${orderId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        AdminStore.ui.showNotification('Statut mis à jour', 'success');
                        AdminStore.orders.refreshTable();
                    } else {
                        AdminStore.ui.showNotification('Erreur lors de la mise à jour', 'error');
                    }
                });
            },
            
            refreshTable: function() {
                const table = document.querySelector('#orders-table');
                if (table) {
                    // Recharger le contenu du tableau
                    fetch(window.location.href + '?ajax=1')
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newTable = doc.querySelector('#orders-table');
                            if (newTable) {
                                table.innerHTML = newTable.innerHTML;
                            }
                        });
                }
            }
        },
        
        // Gestion de l'inventaire
        inventory: {
            checkLowStock: function() {
                fetch(`${AdminStore.config.apiEndpoint}/inventory/low-stock`)
                    .then(response => response.json())
                    .then(products => {
                        AdminStore.state.dashboard.lowStock = products;
                        if (products.length > 0) {
                            AdminStore.ui.updateLowStockWarning(products.length);
                        }
                    });
            },
            
            updateStock: function(productId, quantity, type = 'set') {
                const data = { quantity, type }; // type: 'set', 'add', 'subtract'
                
                fetch(`${AdminStore.config.apiEndpoint}/inventory/${productId}/stock`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        AdminStore.ui.showNotification('Stock mis à jour', 'success');
                        // Mise à jour de l'interface
                        const stockElement = document.querySelector(`[data-product-stock="${productId}"]`);
                        if (stockElement) {
                            stockElement.textContent = result.newStock;
                        }
                    }
                });
            },
            
            bulkUpdate: function(updates) {
                fetch(`${AdminStore.config.apiEndpoint}/inventory/bulk-update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ updates })
                })
                .then(response => response.json())
                .then(result => {
                    AdminStore.ui.showNotification(
                        `${result.updated} produit(s) mis à jour`, 
                        'success'
                    );
                });
            }
        },
        
        // Gestion des graphiques et statistiques
        charts: {
            instances: {},
            
            init: function() {
                // Initialisation des graphiques Chart.js
                AdminStore.charts.createSalesChart();
                AdminStore.charts.createCategoryChart();
                AdminStore.charts.createTrafficChart();
            },
            
            createSalesChart: function() {
                const ctx = document.getElementById('salesChart');
                if (!ctx) return;
                
                AdminStore.charts.instances.sales = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Ventes (FCFA)',
                            data: [],
                            borderColor: 'rgb(139, 92, 246)',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + ' FCFA';
                                    }
                                }
                            }
                        }
                    }
                });
            },
            
            createCategoryChart: function() {
                const ctx = document.getElementById('categoryChart');
                if (!ctx) return;
                
                AdminStore.charts.instances.category = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Parfums', 'Beauté'],
                        datasets: [{
                            data: [],
                            backgroundColor: [
                                'rgba(139, 92, 246, 0.8)',
                                'rgba(236, 72, 153, 0.8)'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            },
            
            createTrafficChart: function() {
                const ctx = document.getElementById('trafficChart');
                if (!ctx) return;
                
                AdminStore.charts.instances.traffic = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Visiteurs',
                            data: [],
                            backgroundColor: 'rgba(34, 197, 94, 0.8)',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
            
            updateAll: function(chartData) {
                if (AdminStore.charts.instances.sales && chartData.sales) {
                    AdminStore.charts.instances.sales.data.labels = chartData.sales.labels;
                    AdminStore.charts.instances.sales.data.datasets[0].data = chartData.sales.data;
                    AdminStore.charts.instances.sales.update();
                }
                
                if (AdminStore.charts.instances.category && chartData.categories) {
                    AdminStore.charts.instances.category.data.datasets[0].data = chartData.categories.data;
                    AdminStore.charts.instances.category.update();
                }
                
                if (AdminStore.charts.instances.traffic && chartData.traffic) {
                    AdminStore.charts.instances.traffic.data.labels = chartData.traffic.labels;
                    AdminStore.charts.instances.traffic.data.datasets[0].data = chartData.traffic.data;
                    AdminStore.charts.instances.traffic.update();
                }
            }
        },
        
        // Gestion de l'interface utilisateur admin
        ui: {
            showNotification: function(message, type = 'info', options = {}) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform translate-x-full transition-all duration-300 max-w-sm ${
                    type === 'success' ? 'bg-green-500 text-white' :
                    type === 'error' ? 'bg-red-500 text-white' :
                    type === 'warning' ? 'bg-yellow-500 text-black' :
                    'bg-blue-500 text-white'
                }`;
                
                let content = `
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-2">
                            <span class="text-lg">
                                ${type === 'success' ? '✅' : 
                                  type === 'error' ? '❌' : 
                                  type === 'warning' ? '⚠️' : 'ℹ️'}
                            </span>
                            <div>
                                <p class="font-medium">${message}</p>
                `;
                
                if (options.action) {
                    content += `
                        <button onclick="${options.callback ? 'this.clickCallback()' : ''}" 
                                class="mt-2 text-sm underline hover:no-underline">
                            ${options.action}
                        </button>
                    `;
                }
                
                content += `
                            </div>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" 
                                class="text-lg font-bold opacity-70 hover:opacity-100">×</button>
                    </div>
                `;
                
                notification.innerHTML = content;
                
                if (options.callback) {
                    notification.querySelector('button').clickCallback = options.callback;
                }
                
                document.body.appendChild(notification);
                
                setTimeout(() => notification.classList.remove('translate-x-full'), 100);
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 5000);
            },
            
            animateCounter: function(element, targetValue) {
                const currentValue = parseInt(element.textContent) || 0;
                const increment = (targetValue - currentValue) / 30;
                let current = currentValue;
                
                const timer = setInterval(() => {
                    current += increment;
                    if ((increment > 0 && current >= targetValue) || 
                        (increment < 0 && current <= targetValue)) {
                        current = targetValue;
                        clearInterval(timer);
                    }
                    element.textContent = Math.round(current);
                }, 50);
            },
            
            updateLowStockWarning: function(count) {
                const badge = document.querySelector('.low-stock-badge');
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'inline-flex' : 'none';
                }
            },
            
            playNotificationSound: function() {
                // Son de notification pour les nouvelles commandes
                const audio = new Audio('/sounds/notification.mp3');
                audio.volume = 0.3;
                audio.play().catch(() => {
                    // Son désactivé par l'utilisateur
                });
            }
        },
        
        // Auto-sauvegarde
        autoSave: {
            init: function() {
                // Détecter les changements dans les formulaires
                document.addEventListener('input', AdminStore.autoSave.markAsChanged);
                document.addEventListener('change', AdminStore.autoSave.markAsChanged);
                
                // Auto-sauvegarde périodique
                setInterval(AdminStore.autoSave.save, AdminStore.config.autoSaveInterval);
                
                // Avertissement avant de quitter la page
                window.addEventListener('beforeunload', AdminStore.autoSave.beforeUnload);
            },
            
            markAsChanged: function(e) {
                if (e.target.closest('form.auto-save')) {
                    AdminStore.state.unsavedChanges = true;
                    AdminStore.autoSave.showUnsavedIndicator();
                }
            },
            
            save: function() {
                if (!AdminStore.state.unsavedChanges) return;
                
                const forms = document.querySelectorAll('form.auto-save');
                forms.forEach(form => {
                    const formData = new FormData(form);
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Auto-Save': 'true'
                        }
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            AdminStore.state.unsavedChanges = false;
                            AdminStore.autoSave.hideUnsavedIndicator();
                        }
                    });
                });
            },
            
            showUnsavedIndicator: function() {
                const indicator = document.querySelector('.unsaved-indicator');
                if (indicator) {
                    indicator.style.display = 'block';
                }
            },
            
            hideUnsavedIndicator: function() {
                const indicator = document.querySelector('.unsaved-indicator');
                if (indicator) {
                    indicator.style.display = 'none';
                }
            },
            
            beforeUnload: function(e) {
                if (AdminStore.state.unsavedChanges) {
                    e.preventDefault();
                    e.returnValue = '';
                    return '';
                }
            }
        },
        
        // Initialisation générale
        init: function() {
            AdminStore.dashboard.init();
            AdminStore.autoSave.init();
            
            // Initialisation des graphiques si Chart.js est disponible
            if (window.Chart) {
                AdminStore.charts.init();
            }
            
            // Vérification des permissions
            AdminStore.checkPermissions();
        },
        
        checkPermissions: function() {
            const userPermissions = AdminStore.state.permissions;
            
            // Masquer les éléments selon les permissions
            document.querySelectorAll('[data-permission]').forEach(element => {
                const requiredPermission = element.dataset.permission;
                if (!userPermissions.includes(requiredPermission)) {
                    element.style.display = 'none';
                }
            });
        }
    };
    
    // Initialisation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        AdminStore.init();
    });
</script>

<!-- Scripts de gestion des fichiers et médias -->
<script>
    window.MediaManager = {
        init: function() {
            MediaManager.setupDropZones();
            MediaManager.setupImagePreviews();
        },
        
        setupDropZones: function() {
            document.querySelectorAll('.drop-zone').forEach(zone => {
                zone.addEventListener('dragover', MediaManager.handleDragOver);
                zone.addEventListener('drop', MediaManager.handleDrop);
                zone.addEventListener('dragleave', MediaManager.handleDragLeave);
            });
        },
        
        handleDragOver: function(e) {
            e.preventDefault();
            e.currentTarget.classList.add('drag-over');
        },
        
        handleDragLeave: function(e) {
            e.currentTarget.classList.remove('drag-over');
        },
        
        handleDrop: function(e) {
            e.preventDefault();
            e.currentTarget.classList.remove('drag-over');
            
            const files = Array.from(e.dataTransfer.files);
            const imageFiles = files.filter(file => file.type.startsWith('image/'));
            
            if (imageFiles.length > 0) {
                MediaManager.uploadFiles(imageFiles, e.currentTarget);
            }
        },
        
        uploadFiles: function(files, dropZone) {
            const formData = new FormData();
            files.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });
            
            const progressBar = dropZone.querySelector('.upload-progress');
            if (progressBar) {
                progressBar.style.display = 'block';
            }
            
            fetch('/admin/media/upload', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    MediaManager.displayUploadedFiles(result.files, dropZone);
                    AdminStore.ui.showNotification(`${files.length} fichier(s) uploadé(s)`, 'success');
                } else {
                    AdminStore.ui.showNotification('Erreur lors de l\'upload', 'error');
                }
            })
            .finally(() => {
                if (progressBar) {
                    progressBar.style.display = 'none';
                }
            });
        },
        
        displayUploadedFiles: function(files, container) {
            const gallery = container.querySelector('.uploaded-files');
            if (!gallery) return;
            
            files.forEach(file => {
                const fileElement = document.createElement('div');
                fileElement.className = 'relative group';
                fileElement.innerHTML = `
                    <img src="${file.thumbnail}" alt="${file.name}" 
                         class="w-20 h-20 object-cover rounded-lg">
                    <button onclick="MediaManager.removeFile('${file.id}')" 
                            class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                        ×
                    </button>
                `;
                gallery.appendChild(fileElement);
            });
        },
        
        removeFile: function(fileId) {
            fetch(`/admin/media/${fileId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    document.querySelector(`[data-file-id="${fileId}"]`).remove();
                }
            });
        },
        
        setupImagePreviews: function() {
            document.querySelectorAll('input[type="file"][accept*="image"]').forEach(input => {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = input.parentElement.querySelector('.image-preview');
                            if (preview) {
                                preview.src = e.target.result;
                                preview.style.display = 'block';
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        }
    };
    
    document.addEventListener('DOMContentLoaded', function() {
        MediaManager.init();
    });
</script>

<!-- Script de sauvegarde et restauration -->
<script>
    window.BackupManager = {
        createBackup: function() {
            AdminStore.ui.showNotification('Création de la sauvegarde...', 'info');
            
            fetch('/admin/backup/create', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    AdminStore.ui.showNotification('Sauvegarde créée avec succès', 'success');
                    BackupManager.refreshBackupList();
                } else {
                    AdminStore.ui.showNotification('Erreur lors de la création', 'error');
                }
            });
        },
        
        refreshBackupList: function() {
            // Recharger la liste des sauvegardes
            fetch('/admin/backup/list')
                .then(response => response.text())
                .then(html => {
                    const container = document.querySelector('#backup-list');
                    if (container) {
                        container.innerHTML = html;
                    }
                });
        }
    };
</script>