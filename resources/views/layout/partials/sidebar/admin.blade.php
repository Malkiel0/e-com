<!-- Sidebar Admin - Navigation Back-office Complète -->
<div class="h-full bg-gradient-to-b from-gray-900 to-gray-800 text-white flex flex-col overflow-hidden" 
     x-data="{ 
        activeMenu: '{{ request()->route()->getName() }}',
        openMenus: [],
        quickStats: {
            orders: 12,
            revenue: 1247,
            products: 156,
            customers: 89
        },
        toggleMenu: function(menu) {
            if (this.openMenus.includes(menu)) {
                this.openMenus = this.openMenus.filter(m => m !== menu);
            } else {
                this.openMenus.push(menu);
            }
        },
        isMenuOpen: function(menu) {
            return this.openMenus.includes(menu);
        }
     }" 
     @toggle-sidebar.window="$el.classList.toggle('-translate-x-full')">
    
    <!-- En-tête de la sidebar -->
    <div class="p-4 border-b border-gray-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white font-bold">
                B&F
            </div>
            <div>
                <h2 class="font-display text-lg font-bold text-white">Beauty & Fragrance</h2>
                <p class="text-xs text-gray-400">Administration</p>
            </div>
        </div>
    </div>
    
    <!-- Statistiques rapides -->
    <div class="p-4 border-b border-gray-700">
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Aperçu rapide</h3>
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-white" x-text="quickStats.orders">12</p>
                        <p class="text-xs text-gray-300">Commandes</p>
                    </div>
                    <div class="w-8 h-8 bg-blue-500/30 rounded-lg flex items-center justify-center">
                        <span class="text-sm">📦</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-white" x-text="quickStats.revenue">1247</p>
                        <p class="text-xs text-gray-300">CA (€)</p>
                    </div>
                    <div class="w-8 h-8 bg-green-500/30 rounded-lg flex items-center justify-center">
                        <span class="text-sm">💰</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-white" x-text="quickStats.products">156</p>
                        <p class="text-xs text-gray-300">Produits</p>
                    </div>
                    <div class="w-8 h-8 bg-purple-500/30 rounded-lg flex items-center justify-center">
                        <span class="text-sm">🌸</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-white" x-text="quickStats.customers">89</p>
                        <p class="text-xs text-gray-300">Clients</p>
                    </div>
                    <div class="w-8 h-8 bg-pink-500/30 rounded-lg flex items-center justify-center">
                        <span class="text-sm">👥</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Navigation principale -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        <nav class="p-4 space-y-2">
            
            <!-- Tableau de bord -->
            <a href="" 
               class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group"
               :class="activeMenu === 'admin.dashboard' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/10 text-gray-300 hover:text-white'">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                     :class="activeMenu === 'admin.dashboard' ? 'bg-white/20' : 'group-hover:bg-white/10'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <span class="font-medium">Tableau de bord</span>
            </a>
            
            <!-- Gestion des commandes -->
            <div>
                <button @click="toggleMenu('orders')" 
                        class="w-full flex items-center justify-between p-3 rounded-lg transition-all duration-200 group"
                        :class="activeMenu.startsWith('admin.orders') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-gray-300 hover:text-white'">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                             :class="activeMenu.startsWith('admin.orders') ? 'bg-white/20' : 'group-hover:bg-white/10'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Commandes</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" 
                         :class="{ 'rotate-90': isMenuOpen('orders') }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Sous-menu commandes -->
                <div x-show="isMenuOpen('orders')" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="ml-11 mt-2 space-y-1">
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.orders.index' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Toutes les commandes
                    </a>
                    <a href="" 
                       class="flex items-center justify-between p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.orders.pending' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        <span>En attente</span>
                        <span class="bg-yellow-500/30 text-yellow-200 px-2 py-0.5 rounded-full text-xs">3</span>
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.orders.processing' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        En traitement
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.orders.completed' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Terminées
                    </a>
                </div>
            </div>
            
            <!-- Gestion des produits -->
            <div>
                <button @click="toggleMenu('products')" 
                        class="w-full flex items-center justify-between p-3 rounded-lg transition-all duration-200 group"
                        :class="activeMenu.startsWith('admin.products') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-gray-300 hover:text-white'">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                             :class="activeMenu.startsWith('admin.products') ? 'bg-white/20' : 'group-hover:bg-white/10'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Produits</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" 
                         :class="{ 'rotate-90': isMenuOpen('products') }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Sous-menu produits -->
                <div x-show="isMenuOpen('products')" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="ml-11 mt-2 space-y-1">
                    <a href="{{ route('createProduct') }}" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.products.index' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Tous les produits
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.products.create' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Ajouter un produit
                    </a>
                    <a href="{{ route('createCategory') }}" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.products.categories' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Catégories
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.products.brands' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Marques
                    </a>
                    <a href="" 
                       class="flex items-center justify-between p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.inventory' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        <span>Stock</span>
                        <span class="bg-red-500/30 text-red-200 px-2 py-0.5 rounded-full text-xs">!</span>
                    </a>
                </div>
            </div>
            
            <!-- Gestion des clients -->
            <a href="" 
               class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group"
               :class="activeMenu === 'admin.customers' ? 'bg-white/20 text-white shadow-lg' : 'hover:bg-white/10 text-gray-300 hover:text-white'">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                     :class="activeMenu === 'admin.customers' ? 'bg-white/20' : 'group-hover:bg-white/10'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <span class="font-medium">Clients</span>
            </a>
            
            <!-- Analytics -->
            <div>
                <button @click="toggleMenu('analytics')" 
                        class="w-full flex items-center justify-between p-3 rounded-lg transition-all duration-200 group"
                        :class="activeMenu.startsWith('admin.analytics') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-gray-300 hover:text-white'">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                             :class="activeMenu.startsWith('admin.analytics') ? 'bg-white/20' : 'group-hover:bg-white/10'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Analytics</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" 
                         :class="{ 'rotate-90': isMenuOpen('analytics') }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <div x-show="isMenuOpen('analytics')" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="ml-11 mt-2 space-y-1">
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.analytics.sales' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Ventes
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.analytics.traffic' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Trafic
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.analytics.conversion' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Conversion
                    </a>
                </div>
            </div>
            
            <!-- Marketing -->
            <div>
                <button @click="toggleMenu('marketing')" 
                        class="w-full flex items-center justify-between p-3 rounded-lg transition-all duration-200 group"
                        :class="activeMenu.startsWith('admin.marketing') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-gray-300 hover:text-white'">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                             :class="activeMenu.startsWith('admin.marketing') ? 'bg-white/20' : 'group-hover:bg-white/10'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Marketing</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" 
                         :class="{ 'rotate-90': isMenuOpen('marketing') }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <div x-show="isMenuOpen('marketing')" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="ml-11 mt-2 space-y-1">
                    <a href="{{ route('promotions') }}" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.promotions' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Promotions
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.newsletter' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Newsletter
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.coupons' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Codes promo
                    </a>
                </div>
            </div>
            
            <!-- Séparateur -->
            <div class="border-t border-gray-700 my-4"></div>
            
            <!-- Configuration -->
            <div>
                <button @click="toggleMenu('settings')" 
                        class="w-full flex items-center justify-between p-3 rounded-lg transition-all duration-200 group"
                        :class="activeMenu.startsWith('admin.settings') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-gray-300 hover:text-white'">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                             :class="activeMenu.startsWith('admin.settings') ? 'bg-white/20' : 'group-hover:bg-white/10'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Configuration</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" 
                         :class="{ 'rotate-90': isMenuOpen('settings') }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <div x-show="isMenuOpen('settings')" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="ml-11 mt-2 space-y-1">
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.settings.general' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Général
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.settings.whatsapp' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        WhatsApp
                    </a>
                    <a href="" 
                       class="block p-2 rounded-lg text-sm transition-colors"
                       :class="activeMenu === 'admin.settings.backup' ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                        Sauvegardes
                    </a>
                </div>
            </div>
        </nav>
    </div>
    
    <!-- Footer de la sidebar -->
    <div class="p-4 border-t border-gray-700 bg-black/20">
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-gray-300">En ligne</span>
            </div>
            <button onclick="BackupManager.createBackup()" 
                    class="text-gray-400 hover:text-white transition-colors"
                    title="Créer une sauvegarde">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
            </button>
        </div>
        
        <div class="mt-3 text-xs text-gray-400">
            <p>Version 1.0.0</p>
            <p>© 2025 Beauty & Fragrance</p>
        </div>
    </div>
</div>

<!-- Styles pour la scrollbar personnalisée -->
<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 2px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style>