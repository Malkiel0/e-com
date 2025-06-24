<!-- Header Admin - Interface de Gestion Avancée -->
<div class="bg-white shadow-sm border-b border-gray-200" 
     x-data="{ 
        notificationsOpen: false,
        profileOpen: false,
        searchOpen: false,
        notifications: [
            {
                id: 1,
                type: 'order',
                title: 'Nouvelle commande',
                message: 'Commande #1234 reçue (89.99€)',
                time: '2 min',
                unread: true,
                icon: '🛍️'
            },
            {
                id: 2,
                type: 'stock',
                title: 'Stock faible',
                message: 'Parfum Rose Éternelle (3 restants)',
                time: '15 min',
                unread: true,
                icon: '⚠️'
            },
            {
                id: 3,
                type: 'user',
                title: 'Nouvel utilisateur',
                message: 'Marie Dubois s\'est inscrite',
                time: '1h',
                unread: false,
                icon: '👤'
            }
        ],
        unreadCount: function() {
            return this.notifications.filter(n => n.unread).length;
        },
        markAsRead: function(id) {
            const notification = this.notifications.find(n => n.id === id);
            if (notification) {
                notification.unread = false;
            }
        },
        markAllAsRead: function() {
            this.notifications.forEach(n => n.unread = false);
        }
     }">
    
    <!-- Barre d'état système -->
    <div class="bg-gradient-to-r from-green-50 to-blue-50 border-b border-green-200 px-4 py-2">
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center space-x-6">
                <!-- Statut système -->
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-green-700 font-medium">Système opérationnel</span>
                </div>
                
                <!-- Statistiques rapides -->
                <div class="hidden md:flex items-center space-x-4 text-gray-600">
                    <span>📊 <strong data-stat="todayOrders">{{ $todayOrders ?? 12 }}</strong> commandes aujourd'hui</span>
                    <span>💰 <strong data-stat="todayRevenue">{{ $todayRevenue ?? '1,247' }}</strong>€ de CA</span>
                    <span>👥 <strong data-stat="onlineUsers">{{ $onlineUsers ?? 34 }}</strong> visiteurs en ligne</span>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Mode sombre/clair -->
                <button class="p-1 rounded hover:bg-white/70 transition-colors">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>
                
                <!-- Lien vers le site -->
                <a href="" 
                   target="_blank"
                   class="flex items-center space-x-1 text-blue-600 hover:text-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    <span class="text-xs">Voir le site</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Header principal -->
    <div class="px-4 lg:px-6">
        <div class="flex items-center justify-between h-16">
            
            <!-- Section gauche -->
            <div class="flex items-center space-x-4">
                <!-- Bouton sidebar mobile -->
                <button @click="$dispatch('toggle-sidebar')" 
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- Logo et titre admin -->
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                        B&F
                    </div>
                    <div class="hidden md:block">
                        <h1 class="text-lg font-semibold text-gray-900">Administration</h1>
                        <p class="text-xs text-gray-500">Beauty & Fragrance</p>
                    </div>
                </div>
                
                <!-- Indicateur de modifications non sauvegardées -->
                <div class="unsaved-indicator hidden bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">
                    <span class="animate-pulse">●</span> Modifications non sauvegardées
                </div>
            </div>
            
            <!-- Section centrale - Recherche -->
            <div class="flex-1 max-w-md mx-8 hidden lg:block">
                <div class="relative">
                    <input type="text" 
                           placeholder="Rechercher commandes, produits, clients..." 
                           @focus="searchOpen = true"
                           @blur="searchOpen = false"
                           class="w-full px-4 py-2 pl-10 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition-all">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    
                    <!-- Résultats de recherche rapide -->
                    <div x-show="searchOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-2">Recherches rapides</h3>
                            <div class="space-y-2">
                                <a href="#" class="block p-2 hover:bg-gray-50 rounded-lg text-sm">
                                    📦 Commandes en attente
                                </a>
                                <a href="#" class="block p-2 hover:bg-gray-50 rounded-lg text-sm">
                                    📉 Produits en rupture
                                </a>
                                <a href="#" class="block p-2 hover:bg-gray-50 rounded-lg text-sm">
                                    👥 Nouveaux clients
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Section droite -->
            <div class="flex items-center space-x-2">
                
                <!-- Recherche mobile -->
                <button class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                
                <!-- Actions rapides -->
                <div class="hidden md:flex items-center space-x-2">
                    <!-- Ajouter produit -->
                    <a href="" 
                       class="p-2 rounded-lg hover:bg-purple-50 text-purple-600 transition-colors"
                       title="Ajouter un produit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </a>
                    
                    <!-- Stock faible -->
                    <button class="relative p-2 rounded-lg hover:bg-yellow-50 text-yellow-600 transition-colors"
                            title="Produits en stock faible">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="low-stock-badge absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                            3
                        </span>
                    </button>
                </div>
                
                <!-- Notifications -->
                <div class="relative">
                    <button @click="notificationsOpen = !notificationsOpen" 
                            class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 17h5l-5-5V9a5 5 0 00-10 0v3l-5 5h5a5 5 0 0010 0z"></path>
                        </svg>
                        <span x-show="unreadCount() > 0" 
                              class="absolute -top-1 -right-1 min-w-[1.25rem] h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-semibold"
                              x-text="unreadCount()"></span>
                    </button>
                    
                    <!-- Dropdown notifications -->
                    <div x-show="notificationsOpen" 
                         @click.away="notificationsOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="absolute right-0 top-full mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
                        
                        <!-- En-tête -->
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900">Notifications</h3>
                            <button @click="markAllAsRead()" 
                                    class="text-sm text-purple-600 hover:text-purple-700">
                                Tout marquer comme lu
                            </button>
                        </div>
                        
                        <!-- Liste des notifications -->
                        <div class="max-h-96 overflow-y-auto">
                            <template x-for="notification in notifications" :key="notification.id">
                                <div @click="markAsRead(notification.id)" 
                                     class="p-4 border-b border-gray-50 hover:bg-gray-50 cursor-pointer transition-colors"
                                     :class="{ 'bg-blue-50': notification.unread }">
                                    <div class="flex items-start space-x-3">
                                        <span class="text-xl" x-text="notification.icon"></span>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2">
                                                <h4 class="font-medium text-gray-900 text-sm" x-text="notification.title"></h4>
                                                <span x-show="notification.unread" 
                                                      class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1" x-text="notification.message"></p>
                                            <span class="text-xs text-gray-400" x-text="notification.time"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Footer -->
                        <div class="p-3 border-t border-gray-100">
                            <a href="" 
                               class="block text-center text-sm text-purple-600 hover:text-purple-700">
                                Voir toutes les notifications
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Profil utilisateur -->
                <div class="relative">
                    <button @click="profileOpen = !profileOpen" 
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                            {{ substr(auth()->user()->name ?? 'Admin', 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'Administrateur' }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown profil -->
                    <div x-show="profileOpen" 
                         @click.away="profileOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
                        
                        <div class="p-3 border-b border-gray-100">
                            <p class="font-medium text-gray-900">{{ auth()->user()->name ?? 'Administrateur' }}</p>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                        </div>
                        
                        <div class="p-2">
                            <a href="" 
                               class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm text-gray-700">Mon profil</span>
                            </a>
                            
                            <a href="" 
                               class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-700">Paramètres</span>
                            </a>
                            
                            <hr class="my-2">
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center space-x-2 p-2 rounded-lg hover:bg-red-50 transition-colors w-full text-left">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="text-sm text-red-600">Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>