<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
    {{-- Message de feedback --}}
    @if($showMessage)
        <div class="fixed top-6 right-6 z-50 transform transition-all duration-500 ease-out"
             x-data="{ show: true }" 
             x-show="show"
             x-transition:enter="transform ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-init="setTimeout(() => show = false, 4000)">
            <div class="bg-gradient-to-r 
                        {{ $messageType === 'success' ? 'from-green-500 to-emerald-500' : '' }}
                        {{ $messageType === 'error' ? 'from-red-500 to-pink-500' : '' }}
                        {{ $messageType === 'info' ? 'from-blue-500 to-indigo-500' : '' }}
                        text-white px-6 py-4 rounded-2xl shadow-2xl">
                <div class="flex items-center space-x-3">
                    @if($messageType === 'success')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @elseif($messageType === 'error')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                    <span class="font-semibold">{{ $message }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- Header du panier --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-6 shadow-2xl">
                <span class="text-4xl">🛒</span>
            </div>
            <h1 class="text-4xl lg:text-5xl font-display font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-4">
                Mon Panier
            </h1>
            @if(!$isCartEmpty)
                <p class="text-xl text-gray-600">
                    {{ $cartCount }} article{{ $cartCount > 1 ? 's' : '' }} pour un total de {{ number_format($total, 2) }}FCFA
                </p>
                
                {{-- Barre de progression livraison gratuite --}}
                @if($subtotal < $freeShippingThreshold)
                    <div class="max-w-md mx-auto mt-6 bg-white/70 backdrop-blur-sm rounded-2xl p-4 border border-blue-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">Livraison gratuite dès {{ $freeShippingThreshold }}FCFA</span>
                            <span class="text-sm font-bold text-blue-600">{{ number_format($savings, 2) }}FCFA restants</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ min(100, ($subtotal / $freeShippingThreshold) * 100) }}%"></div>
                        </div>
                    </div>
                @else
                    <div class="max-w-md mx-auto mt-6 bg-green-50 border border-green-200 rounded-2xl p-4">
                        <div class="flex items-center justify-center space-x-2 text-green-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">🚚 Livraison gratuite acquise !</span>
                        </div>
                    </div>
                @endif
            @else
                <p class="text-xl text-gray-500">Votre panier est actuellement vide</p>
            @endif
        </div>

        @if(!$isCartEmpty)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Articles du panier --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 shadow-xl border border-blue-100">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                                <span class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-sm">📋</span>
                                </span>
                                Articles ({{ $cartCount }})
                            </h2>
                            <button wire:click="clearCart" 
                                    wire:confirm="Êtes-vous sûr de vouloir vider votre panier ?"
                                    class="text-red-600 hover:text-red-800 font-medium text-sm flex items-center space-x-2 hover:bg-red-50 px-3 py-2 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span>Vider le panier</span>
                            </button>
                        </div>

                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="bg-white rounded-2xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100"
                                     x-data="{ 
                                         quantity: {{ $item['quantity'] }},
                                         updating: {{ in_array($item['id'], $updatingQuantities) ? 'true' : 'false' }}
                                     }"
                                     :class="updating ? 'ring-2 ring-blue-500 bg-blue-50' : ''">
                                    
                                    <div class="flex items-center space-x-4">
                                        {{-- Image produit --}}
                                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                            @if(isset($item['product']['images'][0]['file_path']))
                                                <img src="{{ Storage::url($item['product']['images'][0]['file_path']) }}" 
                                                     alt="{{ $item['product']['name'] }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br {{ isset($item['product']['category']['name']) && strpos(strtolower($item['product']['category']['name']), 'parfum') !== false ? 'from-purple-100 to-indigo-100' : 'from-pink-100 to-orange-100' }} flex items-center justify-center">
                                                    <span class="text-2xl">{{ isset($item['product']['category']['name']) && strpos(strtolower($item['product']['category']['name']), 'parfum') !== false ? '🌸' : '💄' }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Informations produit --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-{{ isset($item['product']['category']['name']) && strpos(strtolower($item['product']['category']['name']), 'parfum') !== false ? 'purple' : 'pink' }}-600 mb-1">
                                                        {{ $item['product']['brand']['name'] ?? 'Marque inconnue' }}
                                                    </p>
                                                    <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2">
                                                        {{ $item['product']['name'] ?? 'Nom indisponible' }}
                                                    </h3>
                                                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                        <span class="bg-gray-100 px-2 py-1 rounded-lg">
                                                            {{ $item['product']['category']['name'] ?? 'Catégorie inconnue' }}
                                                        </span>
                                                        @if(isset($item['product']['volume']) && $item['product']['volume'])
                                                            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded-lg">
                                                                {{ $item['product']['volume'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Bouton supprimer --}}
                                                <button wire:click="removeItem({{ $item['id'] }})"
                                                        wire:confirm="Supprimer cet article du panier ?"
                                                        class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all ml-4">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            {{-- Prix et quantité --}}
                                            <div class="flex items-center justify-between mt-4">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-2xl font-bold text-gray-900">{{ $item['product']['price'] }}FCFA</span>
                                                    @if(isset($item['product']['original_price']) && $item['product']['original_price'] > $item['product']['price'])
                                                        <span class="text-lg text-gray-500 line-through">{{ $item['product']['original_price'] }}FCFA</span>
                                                    @endif
                                                </div>

                                                {{-- Contrôles quantité --}}
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-sm text-gray-500">Quantité:</span>
                                                    <div class="flex items-center space-x-2 bg-gray-100 rounded-xl p-1">
                                                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                                                class="w-8 h-8 rounded-lg bg-white hover:bg-gray-50 flex items-center justify-center transition-colors {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                            </svg>
                                                        </button>
                                                        
                                                        <span class="w-8 text-center font-bold text-lg" x-text="quantity"></span>
                                                        
                                                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                                                class="w-8 h-8 rounded-lg bg-white hover:bg-gray-50 flex items-center justify-center transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>

                                                {{-- Total ligne --}}
                                                <div class="text-right">
                                                    <span class="text-sm text-gray-500">Total:</span>
                                                    <p class="text-xl font-bold text-blue-600">
                                                        {{ number_format($item['product']['price'] * $item['quantity'], 2) }}FCFA
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Résumé de commande --}}
                <div class="space-y-6">
                    {{-- Totaux --}}
                    <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 shadow-xl border border-blue-100 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm">💰</span>
                            </span>
                            Résumé de commande
                        </h3>

                        <div class="space-y-4">
                            {{-- Sous-total --}}
                            <div class="flex items-center justify-between py-2">
                                <span class="text-gray-600">Sous-total ({{ $cartCount }} articles)</span>
                                <span class="font-semibold text-gray-900">{{ number_format($subtotal, 2) }}FCFA</span>
                            </div>

                            {{-- TVA --}}
                            <div class="flex items-center justify-between py-2">
                                <span class="text-gray-600">TVA ({{ $taxRate }}%)</span>
                                <span class="font-semibold text-gray-900">{{ number_format($taxAmount, 2) }}FCFA</span>
                            </div>

                            {{-- Livraison --}}
                            <div class="flex items-center justify-between py-2">
                                <span class="text-gray-600">Livraison</span>
                                @if($shippingCost > 0)
                                    <span class="font-semibold text-gray-900">{{ number_format($shippingCost, 2) }}FCFA</span>
                                @else
                                    <span class="font-semibold text-green-600">GRATUITE ✅</span>
                                @endif
                            </div>

                            <hr class="border-gray-200">

                            {{-- Total --}}
                            <div class="flex items-center justify-between py-3">
                                <span class="text-xl font-bold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-blue-600">{{ number_format($total, 2) }}FCFA</span>
                            </div>
                        </div>

                        {{-- Bouton commande WhatsApp --}}
                        <div class="mt-6 space-y-4">
                            <button wire:click="contactWhatsApp"
                                    class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-4 px-6 rounded-2xl font-bold text-lg transition-all transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center justify-center space-x-3">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106"/>
                                </svg>
                                <span>Commander via WhatsApp</span>
                            </button>

                            <div class="text-center">
                                <p class="text-sm text-gray-500">
                                    🔒 Paiement sécurisé • 📞 Support client
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Garanties --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                        <h4 class="font-bold text-gray-900 mb-4">Nos garanties</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-xs">✅</span>
                                </span>
                                <span class="text-gray-700">Produits authentiques garantis</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-xs">🚚</span>
                                </span>
                                <span class="text-gray-700">Livraison soignée et rapide</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-xs">💬</span>
                                </span>
                                <span class="text-gray-700">Support client réactif</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center">
                                    <span class="text-xs">🎁</span>
                                </span>
                                <span class="text-gray-700">Échantillons offerts</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Panier vide --}}
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="text-8xl mb-8">🛒</div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Votre panier est vide</h3>
                    <p class="text-gray-600 mb-8 text-lg">
                        Découvrez notre collection exceptionnelle de parfums et produits de beauté pour commencer votre shopping.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('parfums') }}" 
                           class="bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white px-8 py-4 rounded-2xl font-semibold transition-all transform hover:scale-105 shadow-xl flex items-center justify-center space-x-2">
                            <span>🌸</span>
                            <span>Découvrir les Parfums</span>
                        </a>
                        <a href="{{ route('produitsDeBeauté') }}" 
                           class="bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white px-8 py-4 rounded-2xl font-semibold transition-all transform hover:scale-105 shadow-xl flex items-center justify-center space-x-2">
                            <span>💄</span>
                            <span>Découvrir la Beauté</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Produits recommandés --}}
        @if(count($recommendedProducts) > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center flex items-center justify-center">
                    <span class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-4">
                        <span>✨</span>
                    </span>
                    {{ $isCartEmpty ? 'Nos Coups de Cœur' : 'Vous pourriez aussi aimer' }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($recommendedProducts as $product)
                        <div class="bg-white/70 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group"
                             x-data="{ adding: false }">
                            <div class="relative aspect-square overflow-hidden">
                                @if(isset($product['images'][0]['file_path']))
                                    <img src="{{ Storage::url($product['images'][0]['file_path']) }}" 
                                         alt="{{ $product['name'] }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br {{ isset($product['category']['name']) && strpos(strtolower($product['category']['name']), 'parfum') !== false ? 'from-purple-100 to-indigo-100' : 'from-pink-100 to-orange-100' }} flex items-center justify-center">
                                        <span class="text-6xl">{{ isset($product['category']['name']) && strpos(strtolower($product['category']['name']), 'parfum') !== false ? '🌸' : '💄' }}</span>
                                    </div>
                                @endif

                                {{-- Bouton ajout rapide --}}
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button wire:click="addRecommendedToCart({{ $product['id'] }})"
                                            class="bg-white text-gray-900 px-4 py-2 rounded-xl font-semibold transform scale-90 group-hover:scale-100 transition-all hover:bg-gray-100"
                                            x-on:click="adding = true; setTimeout(() => adding = false, 1000)"
                                            x-bind:disabled="adding">
                                        <span x-show="!adding">+ Ajouter</span>
                                        <span x-show="adding">Ajouté !</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <p class="text-sm font-medium {{ isset($product['category']['name']) && strpos(strtolower($product['category']['name']), 'parfum') !== false ? 'text-purple-600' : 'text-pink-600' }} mb-1">
                                    {{ $product['brand']['name'] ?? 'Marque inconnue' }}
                                </p>
                                <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $product['name'] ?? 'Nom indisponible' }}</h3>
                                <p class="text-lg font-bold text-gray-900">{{ $product['price'] ?? '0' }}FCFA</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Scripts spéciaux --}}
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('open-whatsapp', (event) => {
            window.open(event.url, '_blank');
        });

        Livewire.on('quantity-updated', (event) => {
            // Animation de feedback pour la mise à jour des quantités
            const itemElement = document.querySelector(`[data-item-id="${event.itemId}"]`);
            if (itemElement) {
                itemElement.classList.add('ring-2', 'ring-green-500', 'bg-green-50');
                setTimeout(() => {
                    itemElement.classList.remove('ring-2', 'ring-green-500', 'bg-green-50');
                }, 1000);
            }
        });
    });

    // Animation de suppression d'articles
    document.addEventListener('DOMContentLoaded', function() {
        // Observer pour les animations de suppression
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    mutation.removedNodes.forEach((node) => {
                        if (node.nodeType === 1 && node.classList.contains('cart-item')) {
                            // Article supprimé, animer les autres
                            const remainingItems = document.querySelectorAll('.cart-item');
                            remainingItems.forEach((item, index) => {
                                item.style.transform = 'translateY(-10px)';
                                item.style.opacity = '0.7';
                                setTimeout(() => {
                                    item.style.transform = 'translateY(0)';
                                    item.style.opacity = '1';
                                }, index * 100);
                            });
                        }
                    });
                }
            });
        });

        const cartContainer = document.querySelector('.cart-items-container');
        if (cartContainer) {
            observer.observe(cartContainer, { childList: true });
        }
    });
</script>
@endpush

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Animation pour les mises à jour de quantité */
    .quantity-updating {
        animation: pulse-blue 0.6s ease-in-out;
    }

    @keyframes pulse-blue {
        0%, 100% { 
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
        }
        50% { 
            box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
        }
    }

    /* Animation pour les articles supprimés */
    .cart-item {
        transition: all 0.3s ease-out;
    }

    .cart-item.removing {
        transform: translateX(100%);
        opacity: 0;
    }

    /* Style pour les boutons de quantité */
    .quantity-btn {
        transition: all 0.2s ease;
    }

    .quantity-btn:hover {
        transform: scale(1.1);
    }

    .quantity-btn:active {
        transform: scale(0.95);
    }
</style>
@endpush