<!-- Header Client - Fonctionnalités E-commerce Avancées -->
<div class="bg-gradient-to-r from-purple-50 to-pink-50 border-b border-purple-100 " 
     x-data="{ 
        cartOpen: false,
        wishlistCount: 2,
        cart: [
            {
                id: 1,
                name: 'Parfum Rose Éternelle',
                price: 89.99,
                image: '/images/parfum1.jpg',
                quantity: 1,
                category: 'parfums'
            },
            {
                id: 2,
                name: 'Rouge à Lèvres Satin',
                price: 29.99,
                image: '/images/beaute1.jpg',
                quantity: 2,
                category: 'beaute'
            }
        ],
        cartTotal: function() {
            return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0).toFixed(2);
        },
        removeFromCart: function(id) {
            this.cart = this.cart.filter(item => item.id !== id);
        },
        updateQuantity: function(id, quantity) {
            const item = this.cart.find(item => item.id === id);
            if (item) {
                item.quantity = quantity;
                if (quantity <= 0) {
                    this.removeFromCart(id);
                }
            }
        },
        proceedToWhatsApp: function() {
            let message = 'Bonjour ! Je souhaite commander les produits suivants :\n\n';
            this.cart.forEach(item => {
                message += `• ${item.name} - Quantité: ${item.quantity} - Prix: ${item.price}FCFA\n`;
            });
            message += `\nTotal: ${this.cartTotal()}FCFA\n\nMerci !`;
            const whatsappUrl = `https://wa.me/YOUR_WHATSAPP_NUMBER?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }
     }">
    
    <!-- Barre d'outils client -->
    <div class="container mx-auto px-4 lg:px-8 py-3">
        <div class="flex items-center justify-between">
            
            <!-- Informations utilisateur et localisation -->
            <div class="flex items-center space-x-6">
                <!-- Localisation -->
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="hidden md:inline">Livraison dans tous le Bénin</span>
                    <span class="md:hidden">Bénin</span>
                </div>
                
                <!-- Statut commande express -->
                {{-- <div class="hidden lg:flex items-center space-x-2 text-sm">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-green-600 font-medium">Commande express disponible</span>
                </div> --}}
            </div>
            
            <!-- Actions rapides -->
            <div class="flex items-center space-x-4">
                
                <!-- Favoris/Wishlist -->
                {{-- <button class="relative p-2 rounded-full hover:bg-white/70 transition-colors group">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-pink-500 transition-colors" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span x-show="wishlistCount > 0" 
                          class="absolute -top-1 -right-1 w-4 h-4 bg-pink-500 text-white text-xs rounded-full flex items-center justify-center font-semibold"
                          x-text="wishlistCount"></span>
                </button> --}}
                
                <!-- Comparaison -->
                {{-- <button class="hidden md:block p-2 rounded-full hover:bg-white/70 transition-colors group">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-purple-500 transition-colors" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </button> --}}
                
                <!-- Panier avancé -->
                @livewire('client.header-cart')
                
                <!-- Bouton contact rapide -->
                {{-- <a href="https://wa.me/YOUR_WHATSAPP_NUMBER" 
                   target="_blank"
                   class="hidden lg:flex items-center space-x-2 bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-full font-medium transition-all transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                    </svg>
                    <span class="text-sm">Contact</span>
                </a> --}}
            </div>
        </div>
    </div>
    
    <!-- Barre de filtres rapides (optionnelle) -->
    {{-- <div class="container mx-auto px-4 lg:px-8 py-2 border-t border-purple-100">
        <div class="flex items-center justify-between">
            <!-- Filtres rapides -->
            <div class="flex items-center space-x-4 overflow-x-auto">
                <span class="text-sm font-medium text-gray-600 whitespace-nowrap">Filtres rapides:</span>
                <button class="px-3 py-1 bg-white rounded-full text-sm font-medium text-purple-600 border border-purple-200 hover:bg-purple-50 transition-colors whitespace-nowrap">
                    Nouveautés
                </button>
                <button class="px-3 py-1 bg-white rounded-full text-sm font-medium text-pink-600 border border-pink-200 hover:bg-pink-50 transition-colors whitespace-nowrap">
                    Promotions
                </button>
                <button class="px-3 py-1 bg-white rounded-full text-sm font-medium text-green-600 border border-green-200 hover:bg-green-50 transition-colors whitespace-nowrap">
                    Best-sellers
                </button>
            </div>
            
            <!-- Tri -->
            <div class="hidden md:flex items-center space-x-2">
                <span class="text-sm text-gray-600">Trier par:</span>
                <select class="text-sm border border-gray-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                    <option>Pertinence</option>
                    <option>Prix croissant</option>
                    <option>Prix décroissant</option>
                    <option>Nouveautés</option>
                    <option>Meilleures ventes</option>
                </select>
            </div>
        </div>
    </div> --}}

     <div class="container mx-auto px-4 lg:px-8 py-2 border-t border-purple-100">
        <div class="flex items-center justify-between">
            <!-- Filtres rapides -->
            <div class="flex items-center space-x-4 overflow-x-auto">
                <span class="text-sm font-medium text-gray-600 whitespace-nowrap">Filtres rapides:</span>
                <a href='{{ route('parfums') }}' class="px-3 py-1 bg-white rounded-full text-sm font-medium text-purple-600 border border-purple-200 hover:bg-purple-50 transition-colors whitespace-nowrap">
                    Parfums
                </a>
                <a href='{{ route('produitsDeBeauté') }}' class="px-3 py-1 bg-white rounded-full text-sm font-medium text-pink-600 border border-pink-200 hover:bg-pink-50 transition-colors whitespace-nowrap">
                    Produits de beauté
                </a>
                <a href='{{ route('tous les produits') }}' class="px-3 py-1 bg-white rounded-full text-sm font-medium text-green-600 border border-green-200 hover:bg-green-50 transition-colors whitespace-nowrap">
                    Tous les produits
                </a>
                <a href='{{ route('panier') }}' class="px-3 py-1 bg-white rounded-full text-sm font-medium text-green-600 border border-green-200 hover:bg-green-50 transition-colors whitespace-nowrap">
                    panier
                </a>
            </div>
            
            <!-- Tri -->
            <div class="hidden md:flex items-center space-x-2">
                <span class="text-sm text-gray-600">Trier par:</span>
                <select class="text-sm border border-gray-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                    <option>Pertinence</option>
                    <option>Prix croissant</option>
                    <option>Prix décroissant</option>
                    <option>Nouveautés</option>
                    <option>Meilleures ventes</option>
                </select>
            </div>
        </div>
    </div>
</div>