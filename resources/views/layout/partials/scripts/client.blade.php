<!-- Scripts Client - Interactivité E-commerce Avancée -->

<!-- Analytics et tracking -->
<script>
    // Configuration pour le tracking des conversions
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    
    // Tracking des événements e-commerce
    function trackAddToCart(productData) {
        gtag('event', 'add_to_cart', {
            currency: 'EUR',
            value: productData.price,
            items: [{
                item_id: productData.id,
                item_name: productData.name,
                item_category: productData.category,
                quantity: productData.quantity,
                price: productData.price
            }]
        });
    }
    
    function trackPurchaseIntent(cartData) {
        gtag('event', 'begin_checkout', {
            currency: 'EUR',
            value: cartData.total,
            items: cartData.items
        });
    }
</script>

<!-- Scripts de gestion du panier et des interactions -->
<script>
    // Store global pour la gestion d'état
    window.BeautyStore = {
        // Configuration
        config: {
            whatsappNumber: 'YOUR_WHATSAPP_NUMBER',
            currency: 'EUR',
            taxRate: 0.20,
            freeShippingThreshold: 50
        },
        
        // État global
        state: {
            cart: JSON.parse(localStorage.getItem('beauty_cart') || '[]'),
            wishlist: JSON.parse(localStorage.getItem('beauty_wishlist') || '[]'),
            recentlyViewed: JSON.parse(localStorage.getItem('beauty_recent') || '[]'),
            user: {
                preferences: JSON.parse(localStorage.getItem('beauty_preferences') || '{}'),
                visitCount: parseInt(localStorage.getItem('beauty_visits') || '0') + 1
            }
        },
        
        // Méthodes du panier
        cart: {
            add: function(product) {
                const existingItem = BeautyStore.state.cart.find(item => item.id === product.id);
                
                if (existingItem) {
                    existingItem.quantity += product.quantity || 1;
                } else {
                    BeautyStore.state.cart.push({
                        ...product,
                        quantity: product.quantity || 1,
                        addedAt: new Date().toISOString()
                    });
                }
                
                BeautyStore.cart.save();
                BeautyStore.ui.showNotification(`${product.name} ajouté au panier`, 'success');
                trackAddToCart(product);
                
                // Mise à jour de l'interface
                BeautyStore.ui.updateCartCount();
                BeautyStore.ui.updateCartDropdown();
            },
            
            remove: function(productId) {
                BeautyStore.state.cart = BeautyStore.state.cart.filter(item => item.id !== productId);
                BeautyStore.cart.save();
                BeautyStore.ui.updateCartCount();
                BeautyStore.ui.updateCartDropdown();
                BeautyStore.ui.showNotification('Produit retiré du panier', 'info');
            },
            
            updateQuantity: function(productId, quantity) {
                const item = BeautyStore.state.cart.find(item => item.id === productId);
                if (item) {
                    if (quantity <= 0) {
                        BeautyStore.cart.remove(productId);
                    } else {
                        item.quantity = quantity;
                        BeautyStore.cart.save();
                        BeautyStore.ui.updateCartDropdown();
                    }
                }
            },
            
            getTotal: function() {
                return BeautyStore.state.cart.reduce((total, item) => {
                    return total + (parseFloat(item.price) * item.quantity);
                }, 0);
            },
            
            getItemCount: function() {
                return BeautyStore.state.cart.reduce((count, item) => count + item.quantity, 0);
            },
            
            clear: function() {
                BeautyStore.state.cart = [];
                BeautyStore.cart.save();
                BeautyStore.ui.updateCartCount();
                BeautyStore.ui.updateCartDropdown();
            },
            
            save: function() {
                localStorage.setItem('beauty_cart', JSON.stringify(BeautyStore.state.cart));
            },
            
            proceedToWhatsApp: function() {
                const cart = BeautyStore.state.cart;
                const total = BeautyStore.cart.getTotal();
                
                if (cart.length === 0) {
                    BeautyStore.ui.showNotification('Votre panier est vide', 'warning');
                    return;
                }
                
                let message = `🛍️ *Nouvelle commande Beauty & Fragrance*\n\n`;
                message += `Bonjour ! Je souhaite commander les produits suivants :\n\n`;
                
                cart.forEach((item, index) => {
                    message += `${index + 1}. *${item.name}*\n`;
                    message += `   • Quantité: ${item.quantity}\n`;
                    message += `   • Prix unitaire: ${item.price}€\n`;
                    message += `   • Sous-total: ${(item.price * item.quantity).toFixed(2)}€\n\n`;
                });
                
                message += `💰 *Total: ${total.toFixed(2)}€*\n\n`;
                
                if (total >= BeautyStore.config.freeShippingThreshold) {
                    message += `🚚 Livraison gratuite incluse !\n\n`;
                } else {
                    const remaining = BeautyStore.config.freeShippingThreshold - total;
                    message += `🚚 Ajoutez ${remaining.toFixed(2)}€ pour la livraison gratuite\n\n`;
                }
                
                message += `Merci de me confirmer la disponibilité et les modalités de livraison.\n\n`;
                message += `✨ Beauty & Fragrance - Votre beauté, notre passion`;
                
                const whatsappUrl = `https://wa.me/${BeautyStore.config.whatsappNumber}?text=${encodeURIComponent(message)}`;
                
                // Tracking de l'intention d'achat
                trackPurchaseIntent({
                    total: total,
                    items: cart
                });
                
                window.open(whatsappUrl, '_blank');
                
                // Optionnel : vider le panier après commande
                // BeautyStore.cart.clear();
            }
        },
        
        // Gestion de la wishlist
        wishlist: {
            add: function(product) {
                const exists = BeautyStore.state.wishlist.find(item => item.id === product.id);
                if (!exists) {
                    BeautyStore.state.wishlist.push({
                        ...product,
                        addedAt: new Date().toISOString()
                    });
                    BeautyStore.wishlist.save();
                    BeautyStore.ui.showNotification(`${product.name} ajouté aux favoris`, 'success');
                    BeautyStore.ui.updateWishlistCount();
                }
            },
            
            remove: function(productId) {
                BeautyStore.state.wishlist = BeautyStore.state.wishlist.filter(item => item.id !== productId);
                BeautyStore.wishlist.save();
                BeautyStore.ui.updateWishlistCount();
                BeautyStore.ui.showNotification('Retiré des favoris', 'info');
            },
            
            toggle: function(product) {
                const exists = BeautyStore.state.wishlist.find(item => item.id === product.id);
                if (exists) {
                    BeautyStore.wishlist.remove(product.id);
                } else {
                    BeautyStore.wishlist.add(product);
                }
            },
            
            save: function() {
                localStorage.setItem('beauty_wishlist', JSON.stringify(BeautyStore.state.wishlist));
            }
        },
        
        // Gestion de l'interface utilisateur
        ui: {
            updateCartCount: function() {
                const count = BeautyStore.cart.getItemCount();
                const badges = document.querySelectorAll('.cart-count');
                badges.forEach(badge => {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'flex' : 'none';
                });
            },
            
            updateWishlistCount: function() {
                const count = BeautyStore.state.wishlist.length;
                const badges = document.querySelectorAll('.wishlist-count');
                badges.forEach(badge => {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'flex' : 'none';
                });
            },
            
            updateCartDropdown: function() {
                // Cette fonction sera appelée par Alpine.js pour mettre à jour le dropdown
                if (window.Alpine && window.Alpine.store) {
                    window.Alpine.store('cart').items = BeautyStore.state.cart;
                }
            },
            
            showNotification: function(message, type = 'info') {
                // Création d'une notification toast
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ${
                    type === 'success' ? 'bg-green-500 text-white' :
                    type === 'error' ? 'bg-red-500 text-white' :
                    type === 'warning' ? 'bg-yellow-500 text-black' :
                    'bg-blue-500 text-white'
                }`;
                
                notification.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <span>${type === 'success' ? '✅' : type === 'error' ? '❌' : type === 'warning' ? '⚠️' : 'ℹ️'}</span>
                        <span>${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-2 font-bold">×</button>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Animation d'entrée
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                // Suppression automatique
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
        },
        
        // Gestion des préférences utilisateur
        preferences: {
            setCategory: function(category) {
                BeautyStore.state.user.preferences.preferredCategory = category;
                localStorage.setItem('beauty_preferences', JSON.stringify(BeautyStore.state.user.preferences));
            },
            
            setPriceRange: function(min, max) {
                BeautyStore.state.user.preferences.priceRange = { min, max };
                localStorage.setItem('beauty_preferences', JSON.stringify(BeautyStore.state.user.preferences));
            }
        },
        
        // Initialisation
        init: function() {
            // Mise à jour des compteurs
            BeautyStore.ui.updateCartCount();
            BeautyStore.ui.updateWishlistCount();
            
            // Enregistrement du nombre de visites
            localStorage.setItem('beauty_visits', BeautyStore.state.user.visitCount.toString());
            
            // Configuration Alpine.js stores
            if (window.Alpine) {
                Alpine.store('cart', {
                    items: BeautyStore.state.cart,
                    total: BeautyStore.cart.getTotal(),
                    count: BeautyStore.cart.getItemCount()
                });
                
                Alpine.store('wishlist', {
                    items: BeautyStore.state.wishlist,
                    count: BeautyStore.state.wishlist.length
                });
            }
        }
    };
    
    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        BeautyStore.init();
        
        // Animation d'entrée pour les éléments
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    
                    // Animation spéciale pour les cartes produit
                    if (entry.target.classList.contains('product-card')) {
                        setTimeout(() => {
                            entry.target.style.transform = 'translateY(0)';
                            entry.target.style.opacity = '1';
                        }, Math.random() * 200);
                    }
                }
            });
        }, observerOptions);
        
        // Observer tous les éléments avec animation
        document.querySelectorAll('[data-animate]').forEach(el => {
            observer.observe(el);
        });
    });
</script>

<!-- Scripts de gestion des filtres et recherche -->
<script>
    // Gestionnaire de filtres avancés
    window.FilterManager = {
        activeFilters: {
            category: null,
            priceRange: [0, 500],
            brands: [],
            inStock: true,
            onSale: false,
            isNew: false
        },
        
        applyFilters: function() {
            const products = document.querySelectorAll('.product-item');
            let visibleCount = 0;
            
            products.forEach(product => {
                const shouldShow = FilterManager.matchesFilters(product);
                product.style.display = shouldShow ? 'block' : 'none';
                if (shouldShow) visibleCount++;
            });
            
            // Mise à jour du compteur de résultats
            FilterManager.updateResultCount(visibleCount);
        },
        
        matchesFilters: function(productElement) {
            const productData = JSON.parse(productElement.dataset.product || '{}');
            
            // Filtre par catégorie
            if (FilterManager.activeFilters.category && 
                productData.category !== FilterManager.activeFilters.category) {
                return false;
            }
            
            // Filtre par prix
            const price = parseFloat(productData.price || 0);
            if (price < FilterManager.activeFilters.priceRange[0] || 
                price > FilterManager.activeFilters.priceRange[1]) {
                return false;
            }
            
            // Filtre par marque
            if (FilterManager.activeFilters.brands.length > 0 && 
                !FilterManager.activeFilters.brands.includes(productData.brand)) {
                return false;
            }
            
            // Filtre stock
            if (FilterManager.activeFilters.inStock && !productData.inStock) {
                return false;
            }
            
            return true;
        },
        
        updateResultCount: function(count) {
            const counters = document.querySelectorAll('.filter-result-count');
            counters.forEach(counter => {
                counter.textContent = `${count} produit${count > 1 ? 's' : ''} trouvé${count > 1 ? 's' : ''}`;
            });
        },
        
        reset: function() {
            FilterManager.activeFilters = {
                category: null,
                priceRange: [0, 500],
                brands: [],
                inStock: true,
                onSale: false,
                isNew: false
            };
            FilterManager.applyFilters();
        }
    };
    
    // Gestionnaire de recherche
    window.SearchManager = {
        performSearch: function(query) {
            if (!query || query.length < 2) {
                document.querySelectorAll('.product-item').forEach(item => {
                    item.style.display = 'block';
                });
                return;
            }
            
            const products = document.querySelectorAll('.product-item');
            let resultsCount = 0;
            
            products.forEach(product => {
                const productData = JSON.parse(product.dataset.product || '{}');
                const searchText = `${productData.name} ${productData.brand} ${productData.description}`.toLowerCase();
                const matches = searchText.includes(query.toLowerCase());
                
                product.style.display = matches ? 'block' : 'none';
                if (matches) resultsCount++;
            });
            
            // Affichage des résultats de recherche
            SearchManager.showSearchResults(query, resultsCount);
        },
        
        showSearchResults: function(query, count) {
            const resultContainer = document.querySelector('.search-results');
            if (resultContainer) {
                resultContainer.innerHTML = `
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-blue-900">
                            Résultats pour "${query}" (${count} produit${count > 1 ? 's' : ''})
                        </h3>
                        ${count === 0 ? '<p class="text-blue-700 text-sm mt-1">Aucun produit ne correspond à votre recherche.</p>' : ''}
                    </div>
                `;
            }
        }
    };
</script>

<!-- Scripts de performance et optimisation -->
<script>
    // Lazy loading des images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        });
    }
    
    // Preload des pages importantes
    function preloadPage(url) {
        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = url;
        document.head.appendChild(link);
    }
    
    // Service Worker pour mise en cache
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('SW registered: ', registration);
                })
                .catch(registrationError => {
                    console.log('SW registration failed: ', registrationError);
                });
        });
    }
</script>

<!-- Script de personnalisation dynamique -->
<script>
    // Personnalisation basée sur l'heure et l'usage
    window.PersonalizationEngine = {
        init: function() {
            PersonalizationEngine.setTimeBasedGreeting();
            PersonalizationEngine.showPersonalizedRecommendations();
            PersonalizationEngine.trackUserBehavior();
        },
        
        setTimeBasedGreeting: function() {
            const hour = new Date().getHours();
            let greeting, emoji;
            
            if (hour < 12) {
                greeting = 'Bonjour';
                emoji = '🌅';
            } else if (hour < 18) {
                greeting = 'Bon après-midi';
                emoji = '☀️';
            } else {
                greeting = 'Bonsoir';
                emoji = '🌙';
            }
            
            document.querySelectorAll('.dynamic-greeting').forEach(el => {
                el.textContent = `${emoji} ${greeting} ! Bienvenue dans votre univers beauté ✨`;
            });
        },
        
        showPersonalizedRecommendations: function() {
            const preferences = BeautyStore.state.user.preferences;
            const visitCount = BeautyStore.state.user.visitCount;
            
            if (visitCount > 3 && preferences.preferredCategory) {
                // Afficher des recommandations basées sur les préférences
                PersonalizationEngine.highlightPreferredCategory(preferences.preferredCategory);
            }
        },
        
        highlightPreferredCategory: function(category) {
            const categoryElements = document.querySelectorAll(`[data-category="${category}"]`);
            categoryElements.forEach(el => {
                el.classList.add('preferred-category');
            });
        },
        
        trackUserBehavior: function() {
            // Tracking des clics sur les produits
            document.addEventListener('click', (e) => {
                if (e.target.closest('.product-card')) {
                    const productData = JSON.parse(e.target.closest('.product-card').dataset.product || '{}');
                    PersonalizationEngine.recordProductView(productData);
                }
            });
        },
        
        recordProductView: function(product) {
            const recentlyViewed = BeautyStore.state.recentlyViewed;
            
            // Éviter les doublons
            const existingIndex = recentlyViewed.findIndex(item => item.id === product.id);
            if (existingIndex > -1) {
                recentlyViewed.splice(existingIndex, 1);
            }
            
            // Ajouter en première position
            recentlyViewed.unshift({
                ...product,
                viewedAt: new Date().toISOString()
            });
            
            // Garder seulement les 10 derniers
            BeautyStore.state.recentlyViewed = recentlyViewed.slice(0, 10);
            localStorage.setItem('beauty_recent', JSON.stringify(BeautyStore.state.recentlyViewed));
        }
    };
    
    // Initialisation de la personnalisation
    document.addEventListener('DOMContentLoaded', () => {
        PersonalizationEngine.init();
    });
</script>

<!-- Hotjar ou équivalent pour l'analyse comportementale -->
<script>
    // Configuration pour l'analyse UX (remplacer par vos propres outils)
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:YOUR_HOTJAR_ID,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>