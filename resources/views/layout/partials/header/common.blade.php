{{-- <!-- Header Commun - Navigation Principale -->
<header class="bg-white/95 backdrop-blur-lg border-b border-gray-200/50 sticky top-0 z-50 shadow-sm" 
        x-data="{ 
            mobileMenuOpen: false, 
            searchOpen: false,
            cartCount: 3,
            categories: [
                { name: 'Parfums', slug: 'parfums', color: 'purple', icon: '🌸' },
                { name: 'Beauté', slug: 'beaute', color: 'pink', icon: '💄' }
            ]
        }">
    
    <!-- Barre de notification promotionnelle -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white text-center py-2 text-sm font-medium">
        <div class="container mx-auto px-4 flex items-center justify-center space-x-2">
            <span class="animate-pulse">✨</span>
            <span>Livraison gratuite dès 50FCFA d'achat • Découvrez nos nouveautés</span>
            <span class="animate-pulse">✨</span>
        </div>
    </div>
    
    <!-- Navigation principale -->
    <nav class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            
            <!-- Logo et titre -->
            <div class="flex items-center space-x-4">
                <!-- Bouton menu mobile -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'">
                        </path>
                    </svg>
                </button>
                
                <!-- Logo -->
                <a href="" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <!-- Cercle animé derrière le logo -->
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full opacity-20 group-hover:opacity-30 transition-opacity transform group-hover:scale-110 duration-300"></div>
                        <div class="relative w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-lg lg:text-xl shadow-lg">
                            B&F
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <h1 class="font-display text-xl lg:text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            Beauty & Fragrance
                        </h1>
                        <p class="text-xs text-gray-500 font-medium">Votre univers beauté</p>
                    </div>
                </a>
            </div>
            
            <!-- Navigation desktop -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="" 
                   class="relative group px-4 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                    Accueil
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                
                <!-- Dropdown Catégories -->
                <div class="relative group">
                    <button class="flex items-center space-x-1 px-4 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                        <span>Catégories</span>
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Menu dropdown -->
                    <div class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                        <div class="p-2">
                            <template x-for="category in categories">
                                <a :href="'/categorie/' + category.slug" 
                                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group/item">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg"
                                         :class="category.color === 'purple' ? 'bg-purple-100' : 'bg-pink-100'">
                                        <span x-text="category.icon"></span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 group-hover/item:text-purple-600" x-text="category.name"></h3>
                                        <p class="text-sm text-gray-500">Découvrez notre collection</p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
                
                <a href="" 
                   class="relative group px-4 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                    À propos
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                
                <a href="" 
                   class="relative group px-4 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                    Contact
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>
            
            <!-- Actions (Recherche, Panier, etc.) -->
            <div class="flex items-center space-x-2 lg:space-x-4">
                
                <!-- Bouton de recherche -->
                <button @click="searchOpen = !searchOpen" 
                        class="p-2 lg:p-3 rounded-full hover:bg-gray-100 transition-colors relative group">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-purple-600 transition-colors" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                
                <!-- Panier -->
                <button class="p-2 lg:p-3 rounded-full hover:bg-gray-100 transition-colors relative group">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-purple-600 transition-colors" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m4.5-5h6"></path>
                    </svg>
                    <!-- Badge de compteur -->
                    <span x-show="cartCount > 0" 
                          class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs rounded-full flex items-center justify-center font-semibold animate-pulse"
                          x-text="cartCount"></span>
                </button>
                
                <!-- Bouton WhatsApp -->
                <a href="https://wa.me/YOUR_WHATSAPP_NUMBER" 
                   target="_blank"
                   class="hidden lg:flex items-center space-x-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full font-medium transition-all transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>
        
        <!-- Barre de recherche (masquée par défaut) -->
        <div x-show="searchOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="absolute top-full left-0 right-0 bg-white border-t border-gray-200 shadow-lg">
            <div class="container mx-auto px-4 lg:px-8 py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-1 relative">
                        <input type="text" 
                               placeholder="Rechercher un produit, une marque..." 
                               class="w-full px-4 py-3 pl-12 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button @click="searchOpen = false" 
                            class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-medium hover:shadow-lg transition-all transform hover:scale-105">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Menu mobile -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         class="lg:hidden fixed inset-0 z-50 bg-white">
        
        <div class="flex items-center justify-between p-4 border-b">
            <h2 class="text-lg font-semibold">Menu</h2>
            <button @click="mobileMenuOpen = false" 
                    class="p-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="p-4 space-y-2">
            <a href="" 
               class="block p-3 rounded-lg hover:bg-gray-50 font-medium">
                🏠 Accueil
            </a>
            
            <div class="space-y-1">
                <p class="p-3 font-semibold text-gray-600">Catégories</p>
                <template x-for="category in categories">
                    <a :href="'/categorie/' + category.slug" 
                       class="block p-3 pl-6 rounded-lg hover:bg-gray-50">
                        <span x-text="category.icon + ' ' + category.name"></span>
                    </a>
                </template>
            </div>
            
            <a href="" 
               class="block p-3 rounded-lg hover:bg-gray-50 font-medium">
                ℹ️ À propos
            </a>
            
            <a href="" 
               class="block p-3 rounded-lg hover:bg-gray-50 font-medium">
                📞 Contact
            </a>
            
            <a href="https://wa.me/YOUR_WHATSAPP_NUMBER" 
               target="_blank"
               class="block p-3 rounded-lg bg-green-50 text-green-700 font-medium">
                💬 WhatsApp
            </a>
        </div>
    </div>
</header> --}}