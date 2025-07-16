<div class="relative" x-data="{ cartOpen: @entangle('isOpen') }">
    {{-- Message de feedback --}}
    @if($showMessage)
        <div class="fixed top-6 right-6 z-50 transform transition-all duration-500 ease-out"
             x-data="{ show: true }" 
             x-show="show"
             x-transition:enter="transform ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-init="setTimeout(() => show = false, 3000)">
            <div class="bg-gradient-to-r 
                        {{ $messageType === 'success' ? 'from-green-500 to-emerald-500' : '' }}
                        {{ $messageType === 'error' ? 'from-red-500 to-pink-500' : '' }}
                        {{ $messageType === 'info' ? 'from-blue-500 to-indigo-500' : '' }}
                        text-white px-4 py-3 rounded-xl shadow-2xl text-sm">
                <div class="flex items-center space-x-2">
                    @if($messageType === 'success')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @elseif($messageType === 'error')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                    <span class="font-medium">{{ $message }}</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Bouton panier --}}
    <button wire:click="toggleCart" 
            class="relative p-3 rounded-full hover:bg-white/70 transition-all duration-300 group transform hover:scale-105">
        <svg class="w-6 h-6 text-gray-600 group-hover:text-purple-500 transition-colors" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m4.5-5h6"></path>
        </svg>
        
        {{-- Badge avec animation --}}
        @if($cartCount > 0)
            <span class="absolute -top-1 -right-1 min-w-[1.25rem] h-5 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold animate-bounce shadow-lg">
                {{ $cartCount }}
            </span>
        @endif
    </button>
    
    {{-- Dropdown du panier --}}
    <div x-show="cartOpen" 
         @click.away="$wire.closeCart()"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 transform translate-y-2 scale-95"
         class="absolute right-0 top-full mt-3 w-96 bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl border border-gray-200 z-50 max-h-[32rem] overflow-hidden">
        
        {{-- En-tête du panier --}}
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50/80 to-pink-50/80 rounded-t-3xl">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-xl text-gray-900 flex items-center">
                        <span class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white text-sm">🛒</span>
                        </span>
                        Mon Panier
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $cartCount }} article{{ $cartCount > 1 ? 's' : '' }}
                        @if($cartCount > 0)
                            • {{ number_format($cartTotal, 2) }}FCFA
                        @endif
                    </p>
                </div>
                
                @if(!$isEmpty)
                    <button wire:click="clearCart" 
                            wire:confirm="Vider le panier ?"
                            class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
        
        {{-- Barre de progression livraison gratuite --}}
        @if(!$isEmpty && $freeShippingRemaining > 0)
            <div class="px-6 py-4 bg-blue-50/70 border-b border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-blue-700">🚚 Livraison gratuite dès 30000FCFA</span>
                    <span class="text-sm font-bold text-blue-600">{{ number_format($freeShippingRemaining, 2) }}FCFA restants</span>
                </div>
                <div class="w-full bg-blue-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-300" 
                         style="width: {{ min(100, ($cartTotal / 30000) * 100) }}%"></div>
                </div>
            </div>
        @elseif(!$isEmpty)
            <div class="px-6 py-3 bg-green-50/70 border-b border-gray-100">
                <div class="flex items-center justify-center space-x-2 text-green-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold text-sm">🚚 Livraison gratuite acquise !</span>
                </div>
            </div>
        @endif
        
        {{-- Articles du panier --}}
        <div class="max-h-64 overflow-y-auto">
            @if($isEmpty)
                <div class="p-8 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <span class="text-3xl">🛍️</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Votre panier est vide</h4>
                    <p class="text-sm text-gray-500 mb-4">Découvrez nos produits exceptionnels</p>
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('parfums') }}" 
                           class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:from-purple-600 hover:to-indigo-700 transition-all transform hover:scale-105 flex items-center justify-center space-x-2">
                            <span>🌸</span>
                            <span>Parfums</span>
                        </a>
                        <a href="{{ route('produitsDeBeauté') }}" 
                           class="bg-gradient-to-r from-pink-500 to-orange-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:from-pink-600 hover:to-orange-600 transition-all transform hover:scale-105 flex items-center justify-center space-x-2">
                            <span>💄</span>
                            <span>Beauté</span>
                        </a>
                    </div>
                </div>
            @else
                @foreach($cartItems as $item)
                    <div class="p-4 border-b border-gray-50 hover:bg-gray-50/50 transition-colors" 
                         wire:key="cart-item-{{ $item['id'] }}">
                        <div class="flex items-start space-x-3">
                            {{-- Image produit --}}
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                @if(isset($item['product']['images'][0]['file_path']))
                                    <img src="{{ Storage::url($item['product']['images'][0]['file_path']) }}" 
                                         alt="{{ $item['product']['name'] ?? 'Produit' }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br {{ isset($item['product']['category']['name']) && strpos(strtolower($item['product']['category']['name']), 'parfum') !== false ? 'from-purple-100 to-indigo-100' : 'from-pink-100 to-orange-100' }} flex items-center justify-center">
                                        <span class="text-2xl">{{ isset($item['product']['category']['name']) && strpos(strtolower($item['product']['category']['name']), 'parfum') !== false ? '🌸' : '💄' }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Détails produit --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-{{ isset($item['product']['category']['name']) && strpos(strtolower($item['product']['category']['name']), 'parfum') !== false ? 'purple' : 'pink' }}-600 mb-1">
                                            {{ $item['product']['brand']['name'] ?? 'Marque inconnue' }}
                                        </p>
                                        <h4 class="font-semibold text-gray-900 text-sm line-clamp-2 mb-1">
                                            {{ $item['product']['name'] ?? 'Nom indisponible' }}
                                        </h4>
                                        <p class="text-sm font-bold text-gray-900">
                                            {{ number_format($item['product']['price'] ?? 0, 2) }}FCFA
                                        </p>
                                    </div>
                                    
                                    {{-- Bouton supprimer --}}
                                    <button wire:click="removeItem({{ $item['id'] }})"
                                            wire:confirm="Supprimer cet article ?"
                                            class="p-1 text-gray-400 hover:text-red-500 transition-colors ml-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                {{-- Contrôles quantité --}}
                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                                class="w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-sm font-bold transition-all transform hover:scale-110 {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                            −
                                        </button>
                                        <span class="w-8 text-center font-bold text-sm">{{ $item['quantity'] }}</span>
                                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                                class="w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-sm font-bold transition-all transform hover:scale-110">
                                            +
                                        </button>
                                    </div>
                                    
                                    {{-- Total ligne --}}
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-{{ isset($item['product']['category']['name']) && strpos(strtolower($item['product']['category']['name']), 'parfum') !== false ? 'purple' : 'pink' }}-600">
                                            {{ number_format(($item['product']['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}FCFA
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        {{-- Footer du panier --}}
        @if(!$isEmpty)
            <div class="p-6 border-t border-gray-100 bg-white/90 backdrop-blur-sm rounded-b-3xl">
                {{-- Total --}}
                <div class="flex justify-between items-center mb-6">
                    <span class="font-bold text-gray-900 text-lg">Total:</span>
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        {{ number_format($cartTotal, 2) }}FCFA
                    </span>
                </div>
                
                {{-- Boutons d'action --}}
                <div class="space-y-3">
                    {{-- Commander WhatsApp --}}
                    <button wire:click="contactWhatsApp" 
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-3 px-4 rounded-2xl font-bold transition-all transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106"/>
                        </svg>
                        <span>Commander sur WhatsApp</span>
                    </button>
                    
                    {{-- Voir le panier complet --}}
                    <button wire:click="goToCart" 
                            class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white py-3 px-4 rounded-2xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                        Voir mon panier complet
                    </button>
                    
                    {{-- Continuer shopping --}}
                    <button wire:click="closeCart" 
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-xl font-medium transition-colors">
                        Continuer mes achats
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Scripts --}}
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('open-whatsapp', (event) => {
            window.open(event.url, '_blank');
        });

        // Auto-fermer le panier après WhatsApp
        Livewire.on('cart-updated', () => {
            // Optionnel: fermer automatiquement après mise à jour
        });
    });
</script>
@endpush

{{-- Styles spéciaux --}}
@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Animation pour les boutons quantité */
    .quantity-btn {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .quantity-btn:hover {
        transform: scale(1.1);
    }

    .quantity-btn:active {
        transform: scale(0.95);
    }

    /* Animation de pulse pour le badge */
    @keyframes cart-bounce {
        0%, 20%, 53%, 80%, 100% {
            transform: translate3d(0,0,0);
        }
        40%, 43% {
            transform: translate3d(0, -8px, 0);
        }
        70% {
            transform: translate3d(0, -4px, 0);
        }
        90% {
            transform: translate3d(0, -2px, 0);
        }
    }

    .cart-badge {
        animation: cart-bounce 1s ease-in-out;
    }
</style>
@endpush