<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-orange-50">
    {{-- Header spécial beauté --}}
    <div
        class="bg-gradient-to-r from-pink-500/10 via-rose-500/10 to-orange-500/10 backdrop-blur-sm z-40 border-b border-pink-200">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-pink-500 to-orange-500 rounded-full mb-6 shadow-2xl">
                    <span class="text-4xl">💄</span>
                </div>
                <h1
                    class="text-4xl lg:text-5xl font-display font-bold bg-gradient-to-r from-pink-600 via-rose-600 to-orange-600 bg-clip-text text-transparent mb-4">
                    Collection Beauté
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Sublimez votre beauté avec notre gamme complète de soins et maquillage premium
                </p>
                <div class="flex items-center justify-center space-x-6 mt-6 text-sm text-gray-500">
                    <span class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                        <span>{{ $products->total() }} produits beauté</span>
                    </span>
                    <span class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-rose-500 rounded-full"></span>
                        <span>Tous types de peau</span>
                    </span>
                    <span class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                        <span>Produits certifiés</span>
                    </span>
                </div>
            </div>

            {{-- Barre de recherche spéciale beauté --}}
            <div class="max-w-2xl mx-auto">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Rechercher un produit beauté, une marque, un type de peau..."
                        class="w-full pl-14 pr-12 py-4 rounded-2xl border border-pink-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent outline-none bg-white/80 backdrop-blur-sm text-lg shadow-xl">
                    <div class="absolute left-5 top-1/2 transform -translate-y-1/2">
                        <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    @if ($search)
                        <button wire:click="$set('search', '')"
                            class="absolute right-5 top-1/2 transform -translate-y-1/2 text-pink-400 hover:text-pink-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Bouton filtres mobile --}}
            <div class="flex justify-center mt-6">
                <button wire:click="$toggle('showFilters')"
                    class="lg:hidden bg-gradient-to-r from-pink-500 to-orange-500 text-white px-8 py-3 rounded-2xl font-semibold flex items-center space-x-3 hover:from-pink-600 hover:to-orange-600 transition-all transform hover:scale-105 shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                    <span>Filtres & Tri</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Message de succès panier SIMPLIFIÉ (comme Dashboar et Parfums) --}}
    @if ($showCartSuccess)
        <div id="cart-notification" 
             class="cart-notification-hidden"
             data-message="{{ $cartMessage }}">
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Sidebar Filtres Beauté --}}
            <div class="lg:w-80 {{ $showFilters ? 'block' : 'hidden lg:block' }}">
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-2xl border border-pink-100 sticky top-32">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-pink-500 to-orange-500 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white text-sm">💄</span>
                        </div>
                        Filtres Beauté
                    </h3>

                    {{-- Catégories --}}
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-xs">🌟</span>
                            </span>
                            Catégories
                        </h4>
                        <select wire:model.live="selectedCategory"
                            class="w-full p-3 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent outline-none bg-white/70">
                            <option value="">Toutes les catégories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->icon }} {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Marques --}}
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-6 h-6 bg-rose-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-xs">✨</span>
                            </span>
                            Marques Premium
                        </h4>
                        <select wire:model.live="selectedBrand"
                            class="w-full p-3 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent outline-none bg-white/70">
                            <option value="">Toutes les marques</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Types de peau --}}
                    @if ($skinTypes->count() > 0)
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-xs">🌺</span>
                                </span>
                                Types de Peau
                            </h4>
                            <div class="grid grid-cols-1 gap-2">
                                @foreach ($skinTypes as $skinType)
                                    <button
                                        wire:click="$set('selectedSkinType', '{{ $selectedSkinType === $skinType ? '' : $skinType }}')"
                                        class="p-3 rounded-xl text-sm font-medium transition-all text-left {{ $selectedSkinType === $skinType ? 'bg-gradient-to-r from-pink-500 to-orange-500 text-white' : 'bg-pink-50 text-pink-700 hover:bg-pink-100' }}">
                                        {{ $skinType }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Prix --}}
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-xs">💰</span>
                            </span>
                            Gamme de Prix
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm text-gray-600 block mb-2">
                                    Prix minimum: <span class="font-semibold text-pink-600">{{ number_format($minPrice, 0, ',', ' ') }} FCFA</span>
                                </label>
                                <input type="range" 
                                    wire:model.live.debounce.300ms="minPrice" 
                                    min="0"
                                    max="{{ $maxPrice }}"
                                    step="1000"
                                    class="w-full h-2 bg-pink-200 rounded-lg appearance-none cursor-pointer pink-slider">
                            </div>
                            <div>
                                <label class="text-sm text-gray-600 block mb-2">
                                    Prix maximum: <span class="font-semibold text-pink-600">{{ number_format($maxPrice, 0, ',', ' ') }} FCFA</span>
                                </label>
                                <input type="range" 
                                    wire:model.live.debounce.300ms="maxPrice" 
                                    min="{{ $minPrice }}"
                                    max="1000000"
                                    step="1000"
                                    class="w-full h-2 bg-pink-200 rounded-lg appearance-none cursor-pointer pink-slider">
                            </div>
                        </div>
                    </div>

                    {{-- Tri --}}
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-6 h-6 bg-violet-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-xs">📊</span>
                            </span>
                            Trier par
                        </h4>
                        <div class="grid grid-cols-2 gap-2">
                            <button wire:click="sortBy('name')"
                                class="p-3 rounded-xl text-sm font-medium transition-all duration-200 {{ $sortBy === 'name' ? 'bg-gradient-to-r from-pink-500 to-orange-500 text-white shadow-lg' : 'bg-pink-50 text-pink-700 hover:bg-pink-100' }}">
                                <span class="flex items-center justify-center space-x-1">
                                    <span>Nom</span>
                                    @if($sortBy === 'name')
                                        <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </span>
                            </button>
                            <button wire:click="sortBy('price')"
                                class="p-3 rounded-xl text-sm font-medium transition-all duration-200 {{ $sortBy === 'price' ? 'bg-gradient-to-r from-pink-500 to-orange-500 text-white shadow-lg' : 'bg-pink-50 text-pink-700 hover:bg-pink-100' }}">
                                <span class="flex items-center justify-center space-x-1">
                                    <span>Prix</span>
                                    @if($sortBy === 'price')
                                        <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </span>
                            </button>
                            <button wire:click="sortBy('rating')"
                                class="p-3 rounded-xl text-sm font-medium transition-all duration-200 {{ $sortBy === 'rating' ? 'bg-gradient-to-r from-pink-500 to-orange-500 text-white shadow-lg' : 'bg-pink-50 text-pink-700 hover:bg-pink-100' }}">
                                <span class="flex items-center justify-center space-x-1">
                                    <span>Note</span>
                                    @if($sortBy === 'rating')
                                        <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </span>
                            </button>
                            <button wire:click="sortBy('sales')"
                                class="p-3 rounded-xl text-sm font-medium transition-all duration-200 {{ $sortBy === 'sales' ? 'bg-gradient-to-r from-pink-500 to-orange-500 text-white shadow-lg' : 'bg-pink-50 text-pink-700 hover:bg-pink-100' }}">
                                <span class="flex items-center justify-center space-x-1">
                                    <span>Ventes</span>
                                    @if($sortBy === 'sales')
                                        <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </span>
                            </button>
                        </div>
                    </div>

                    {{-- Bouton reset filtres --}}
                    <button
                        wire:click="resetFilters"
                        class="w-full bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 py-3 rounded-xl font-medium transition-all flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        <span>Réinitialiser</span>
                    </button>
                </div>
            </div>

            {{-- Grille Produits Beauté --}}
            <div class="flex-1">
                {{-- En-tête résultats --}}
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <p class="text-gray-600">
                            <span class="font-bold text-pink-600 text-lg">{{ $products->total() }}</span> produits de
                            beauté
                        </p>
                        @if ($search)
                            <p class="text-sm text-gray-500 mt-1">Résultats pour "{{ $search }}"</p>
                        @endif
                    </div>

                    {{-- Mode d'affichage --}}
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-1 bg-pink-100 rounded-lg p-1">
                            <button wire:click="$set('viewMode', 'grid')"
                                class="p-2 rounded-md {{ $viewMode === 'grid' ? 'bg-white shadow-sm text-pink-600' : 'text-pink-400' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                            </button>
                            <button wire:click="$set('viewMode', 'list')"
                                class="p-2 rounded-md {{ $viewMode === 'list' ? 'bg-white shadow-sm text-pink-600' : 'text-pink-400' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Grille/Liste des produits beauté --}}
                @if ($products->count() > 0)
                    <div
                        class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8' : 'space-y-6' }}">
                        @foreach ($products as $product)
                            <div class="group" data-product-id="{{ $product->id }}" x-data="{
                                inWishlist: {{ in_array($product->id, $userWishlist) ? 'true' : 'false' }},
                                loading: false
                            }">

                                @if ($viewMode === 'grid')
                                    {{-- Vue grille beauté --}}
                                    <div
                                        class="bg-white/80 backdrop-blur-sm rounded-3xl overflow-hidden shadow-xl border border-pink-100 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-105">
                                        {{-- Image produit beauté --}}
                                        <div class="relative aspect-square overflow-hidden cursor-pointer"
                                            wire:click="viewProduct({{ $product->id }})">

                                            @if ($product->primaryImage)
                                                <img src="{{ Storage::url($product->primaryImage->file_path) }}"
                                                    alt="{{ $product->name }}"
                                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                                    loading="lazy">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-pink-100 via-rose-100 to-orange-100 flex items-center justify-center">
                                                    <span class="text-8xl">💄</span>
                                                </div>
                                            @endif

                                            {{-- Overlay gradient --}}
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-pink-900/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>

                                            {{-- Badges beauté --}}
                                            <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                                @if ($product->is_new)
                                                    <span
                                                        class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                                        ✨ NOUVEAU
                                                    </span>
                                                @endif
                                                @if ($product->original_price && $product->price < $product->original_price)
                                                    <span
                                                        class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                                        -{{ $product->discount_percentage }}%
                                                    </span>
                                                @endif
                                                @if ($product->is_bestseller)
                                                    <span
                                                        class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                                        🔥 BEST
                                                    </span>
                                                @endif
                                                @if ($product->skin_type)
                                                    <span
                                                        class="bg-gradient-to-r from-pink-500 to-rose-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                                        {{ $product->skin_type }}
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Actions rapides --}}
                                            <div
                                                class="absolute top-4 right-4 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0">
                                                {{-- Favoris --}}
                                                <button wire:click.stop="toggleWishlist({{ $product->id }})"
                                                    :class="inWishlist ? 'bg-red-500 text-white' : 'bg-white/90 text-gray-600'"
                                                    class="w-11 h-11 backdrop-blur-sm rounded-full flex items-center justify-center hover:scale-110 transition-all shadow-xl">
                                                    <svg class="w-5 h-5" :fill="inWishlist ? 'currentColor' : 'none'"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                        </path>
                                                    </svg>
                                                </button>

                                                {{-- Vue rapide --}}
                                                <button wire:click.stop="viewProduct({{ $product->id }})"
                                                    class="w-11 h-11 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-pink-600 hover:scale-110 transition-all shadow-xl">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </button>

                                                {{-- Contact WhatsApp --}}
                                                <button wire:click.stop="contactWhatsApp({{ $product->id }})"
                                                    class="w-11 h-11 bg-green-500 text-white rounded-full flex items-center justify-center hover:scale-110 transition-all shadow-xl">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Informations produit beauté --}}
                                        <div class="p-6">
                                            {{-- Marque --}}
                                            <p
                                                class="text-sm font-semibold text-pink-600 mb-2 uppercase tracking-wide">
                                                {{ $product->brand->name }}
                                            </p>

                                            {{-- Nom --}}
                                            <h3 class="font-bold text-gray-900 text-lg mb-3 line-clamp-2 cursor-pointer hover:text-pink-600 transition-colors"
                                                wire:click="viewProduct({{ $product->id }})">
                                                {{ $product->name }}
                                            </h3>

                                            {{-- Catégorie et type de peau --}}
                                            <div class="flex items-center space-x-3 mb-3 text-sm text-gray-600">
                                                <span
                                                    class="bg-pink-50 text-pink-700 px-2 py-1 rounded-lg font-medium">
                                                    {{ $product->category->name }}
                                                </span>
                                                @if ($product->skin_type)
                                                    <span
                                                        class="bg-rose-50 text-rose-700 px-2 py-1 rounded-lg font-medium">
                                                        🌟 {{ $product->skin_type }}
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Prix --}}
                                            <div class="mb-4">
                                                <div class="flex items-center space-x-2 mb-4 flex-wrap">
                                                    <span
                                                        class="text-2xl font-bold text-gray-900 whitespace-nowrap">{{ number_format($product->price, 0, ',', ' ') }}&nbsp;FCFA</span>
                                                    @if ($product->original_price && $product->price < $product->original_price)
                                                        <span
                                                            class="text-lg text-gray-500 line-through whitespace-nowrap">{{ number_format($product->original_price, 0, ',', ' ') }}&nbsp;FCFA</span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Note --}}
                                            @if ($product->rating_average > 0)
                                                <div class="flex items-center space-x-2 mb-4">
                                                    <div class="flex items-center space-x-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= $product->rating_average ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                                </path>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <span
                                                        class="text-sm text-gray-500">({{ $product->reviews_count }})</span>
                                                </div>
                                            @endif

                                            {{-- Stock --}}
                                            <div class="mb-4">
                                                @if ($product->is_in_stock)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                        ✅ Disponible
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                        ❌ Rupture
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Bouton ajout panier --}}
                                            @if ($product->is_in_stock)
                                                <button wire:click="addToCart({{ $product->id }})"
                                                    class="w-full py-3 px-4 rounded-2xl font-semibold text-white transition-all transform hover:scale-105 shadow-lg hover:shadow-xl bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600"
                                                    x-bind:disabled="loading"
                                                    x-on:click="loading = true; setTimeout(() => loading = false, 1000)">
                                                    <span x-show="!loading"
                                                        class="flex items-center justify-center space-x-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5M7 13h10m0 0l1.1 5M17 17a2 2 0 11-4 0 2 2 0 014 0zM9 17a2 2 0 11-4 0 2 2 0 014 0z">
                                                            </path>
                                                        </svg>
                                                        <span>Ajouter au panier</span>
                                                    </span>
                                                    <span x-show="loading"
                                                        class="flex items-center justify-center space-x-2">
                                                        <svg class="animate-spin w-5 h-5" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12"
                                                                r="10" stroke="currentColor" stroke-width="4">
                                                            </circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                            </path>
                                                        </svg>
                                                        <span>Ajout...</span>
                                                    </span>
                                                </button>
                                            @else
                                                <button disabled
                                                    class="w-full bg-gray-300 text-gray-500 py-3 px-4 rounded-2xl font-semibold cursor-not-allowed">
                                                    Rupture de stock
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    {{-- Vue liste beauté (identique mais avec couleurs rose/orange) --}}
                                    <div
                                        class="bg-white/80 backdrop-blur-sm rounded-3xl overflow-hidden shadow-xl border border-pink-100 hover:shadow-2xl transition-all duration-300">
                                        <div class="flex flex-col md:flex-row">
                                            {{-- Image --}}
                                            <div class="md:w-48 h-48 relative overflow-hidden cursor-pointer"
                                                wire:click="viewProduct({{ $product->id }})">
                                                @if ($product->primaryImage)
                                                    <img src="{{ Storage::url($product->primaryImage->file_path) }}"
                                                        alt="{{ $product->name }}"
                                                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                                                        loading="lazy">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-gradient-to-br from-pink-100 via-rose-100 to-orange-100 flex items-center justify-center">
                                                        <span class="text-6xl">💄</span>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Contenu liste beauté --}}
                                            <div class="flex-1 p-6">
                                                <div
                                                    class="flex flex-col md:flex-row md:items-center justify-between h-full">
                                                    <div class="flex-1">
                                                        {{-- Marque --}}
                                                        <p
                                                            class="text-sm font-semibold text-pink-600 mb-2 uppercase tracking-wide">
                                                            {{ $product->brand->name }}
                                                        </p>

                                                        {{-- Nom --}}
                                                        <h3 class="font-bold text-xl text-gray-900 mb-2 cursor-pointer hover:text-pink-600 transition-colors"
                                                            wire:click="viewProduct({{ $product->id }})">
                                                            {{ $product->name }}
                                                        </h3>

                                                        {{-- Description courte --}}
                                                        @if ($product->short_description)
                                                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                                                {{ $product->short_description }}
                                                            </p>
                                                        @endif

                                                        {{-- Caractéristiques --}}
                                                        <div class="flex flex-wrap items-center gap-2 mb-3">
                                                            <span
                                                                class="bg-pink-50 text-pink-700 px-2 py-1 rounded-lg text-xs font-medium">
                                                                {{ $product->category->name }}
                                                            </span>
                                                            @if ($product->skin_type)
                                                                <span
                                                                    class="bg-rose-50 text-rose-700 px-2 py-1 rounded-lg text-xs font-medium">
                                                                    🌟 {{ $product->skin_type }}
                                                                </span>
                                                            @endif

                                                            @if ($product->rating_average > 0)
                                                                <div class="flex items-center space-x-1">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <svg class="w-4 h-4 {{ $i <= $product->rating_average ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                            fill="currentColor" viewBox="0 0 20 20">
                                                                            <path
                                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                                            </path>
                                                                        </svg>
                                                                    @endfor
                                                                    <span
                                                                        class="text-sm text-gray-500 ml-1">({{ $product->reviews_count }})</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- Prix et actions --}}
                                                    <div class="md:text-right md:ml-6">
                                                        {{-- Prix --}}
                                                        <div class="mb-4">
                                                            <div
                                                                class="flex md:flex-col items-center md:items-end space-x-2 md:space-x-0">
                                                                <span
                                                                    class="text-2xl font-bold text-gray-900">{{ number_format($product->price, 0, ',', ' ') }}
                                                                    FCFA</span>
                                                                @if ($product->original_price && $product->price < $product->original_price)
                                                                    <div class="md:mt-1">
                                                                        <span
                                                                            class="text-lg text-gray-500 line-through">{{ number_format($product->original_price, 0, ',', ' ') }}
                                                                            FCFA</span>
                                                                        <span
                                                                            class="text-sm font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full ml-2">
                                                                            -{{ $product->discount_percentage }}%
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        {{-- Actions --}}
                                                        <div
                                                            class="flex md:flex-col space-x-2 md:space-x-0 md:space-y-2">
                                                            @if ($product->is_in_stock)
                                                                <button wire:click="addToCart({{ $product->id }})"
                                                                    class="flex-1 md:w-auto py-2 px-4 rounded-xl font-semibold text-white transition-all transform hover:scale-105 bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600">
                                                                    Ajouter au panier
                                                                </button>
                                                            @else
                                                                <button disabled
                                                                    class="flex-1 md:w-auto bg-gray-300 text-gray-500 py-2 px-4 rounded-xl font-semibold cursor-not-allowed">
                                                                    Rupture
                                                                </button>
                                                            @endif

                                                            <div class="flex space-x-2">
                                                                {{-- Favoris --}}
                                                                <button
                                                                    wire:click="toggleWishlist({{ $product->id }})"
                                                                    :class="inWishlist ? 'bg-red-500 text-white' :
                                                                        'bg-pink-100 text-pink-600'"
                                                                    class="p-2 rounded-xl hover:scale-110 transition-all">
                                                                    <svg class="w-5 h-5"
                                                                        :fill="inWishlist ? 'currentColor' : 'none'"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                                        </path>
                                                                    </svg>
                                                                </button>

                                                                {{-- Contact --}}
                                                                <button
                                                                    wire:click="contactWhatsApp({{ $product->id }})"
                                                                    class="p-2 bg-green-500 text-white rounded-xl hover:scale-110 transition-all">
                                                                    <svg class="w-5 h-5" fill="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $products->links('components.custom-pagination') }}
                    </div>
                @else
                    {{-- Aucun produit beauté --}}
                    <div class="text-center py-20">
                        <div class="max-w-md mx-auto">
                            <div class="text-8xl mb-8">💄</div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-4">Aucun produit beauté trouvé</h3>
                            <p class="text-gray-600 mb-8 text-lg">
                                Nous n'avons trouvé aucun produit de beauté correspondant à vos critères.
                                Essayez de modifier vos filtres pour découvrir notre collection.
                            </p>
                            <button
                                wire:click="resetFilters"
                                class="bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white px-8 py-4 rounded-2xl font-semibold transition-all transform hover:scale-105 shadow-xl">
                                🔄 Réinitialiser les filtres
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Quick View CORRIGÉE avec scroll automatique (comme Parfums) --}}
    @if ($showQuickView && $selectedProduct)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] overflow-y-auto"
            id="modal-overlay"
            x-data="{
                show: @entangle('showQuickView'),
                currentImage: '{{ $selectedProduct->primaryImage?->file_path }}',
                showZoom: false,
                changeImage(imagePath) {
                    this.currentImage = imagePath;
                },
                toggleZoom() {
                    this.showZoom = !this.showZoom;
                }
            }" 
            x-show="show" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100"
            x-on:click="$wire.closeQuickView()">

            <div class="min-h-screen flex items-start justify-center p-4 pt-16">
                <div class="bg-white rounded-3xl w-full max-w-6xl mx-auto shadow-2xl border border-pink-100 max-h-[85vh] overflow-y-auto"
                    x-transition:enter="transition ease-out duration-300" 
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-on:click.stop>

                {{-- Header modal FIXE --}}
                <div class="sticky top-0 bg-gradient-to-r from-pink-500/10 to-orange-500/10 backdrop-blur-sm border-b border-pink-200 p-4 md:p-6 rounded-t-3xl z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 md:w-10 h-8 md:h-10 bg-gradient-to-r from-pink-500 to-orange-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm md:text-base">💄</span>
                            </div>
                            <h2 class="text-lg md:text-2xl font-bold bg-gradient-to-r from-pink-600 to-orange-600 bg-clip-text text-transparent">
                                Aperçu Beauté
                            </h2>
                        </div>
                        <button wire:click="closeQuickView"
                            class="p-2 hover:bg-pink-100 rounded-full transition-colors text-pink-600 z-20">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Contenu modal RESPONSIVE --}}
                <div class="p-4 md:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-10">
                        {{-- Images --}}
                        <div class="space-y-4 md:space-y-6">
                            {{-- Image principale --}}
                            <div class="aspect-square rounded-2xl md:rounded-3xl overflow-hidden bg-gradient-to-br from-pink-50 to-orange-50 shadow-xl relative cursor-zoom-in"
                                @click="toggleZoom()">
                                @if ($selectedProduct->primaryImage)
                                    <img x-bind:src="currentImage ? '{{ asset('storage/') }}/' + currentImage :
                                        '{{ Storage::url($selectedProduct->primaryImage->file_path) }}'"
                                        alt="{{ $selectedProduct->name }}"
                                        class="w-full h-full object-cover transition-transform duration-300"
                                        x-bind:class="showZoom ? 'scale-150 cursor-zoom-out' : 'scale-100 cursor-zoom-in'">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-pink-100 via-rose-100 to-orange-100 flex items-center justify-center">
                                        <span class="text-6xl md:text-8xl">💄</span>
                                    </div>
                                @endif

                                {{-- Indicateur de zoom --}}
                                <div class="absolute top-2 md:top-4 right-2 md:right-4 bg-black/50 text-white px-2 py-1 rounded-lg text-xs">
                                    <span x-show="!showZoom">🔍 Cliquer pour zoomer</span>
                                    <span x-show="showZoom">🔍 Cliquer pour dézoomer</span>
                                </div>
                            </div>

                            {{-- Galerie thumbnails --}}
                            @if ($selectedProduct->images->count() > 1)
                                <div class="grid grid-cols-4 gap-2 md:gap-3">
                                    @foreach ($selectedProduct->images->take(4) as $image)
                                        <div class="aspect-square rounded-lg md:rounded-xl overflow-hidden bg-pink-50 cursor-pointer hover:opacity-75 transition-all shadow-lg border-2"
                                            x-bind:class="currentImage === '{{ $image->file_path }}' ?
                                                'border-pink-500 ring-2 ring-pink-200' : 'border-transparent'"
                                            @click="changeImage('{{ $image->file_path }}')">
                                            <img src="{{ Storage::url($image->file_path) }}"
                                                alt="{{ $selectedProduct->name }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Informations beauté --}}
                        <div class="space-y-4 md:space-y-6">
                            {{-- En-tête produit --}}
                            <div>
                                <div class="flex items-center space-x-3 mb-3">
                                    <span class="text-base md:text-lg font-bold text-pink-600 uppercase tracking-wide">
                                        {{ $selectedProduct->brand->name }}
                                    </span>
                                    <span class="text-xs md:text-sm text-gray-500 bg-pink-50 px-2 md:px-3 py-1 rounded-full">
                                        {{ $selectedProduct->category->name }}
                                    </span>
                                </div>

                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 md:mb-6">{{ $selectedProduct->name }}</h1>

                                {{-- Prix RESPONSIVE --}}
                                <div class="flex flex-wrap items-center gap-2 md:gap-3 mb-4 md:mb-6">
                                    <span class="text-2xl md:text-4xl font-bold text-gray-900">{{ number_format($selectedProduct->price, 0, ',', ' ') }}&nbsp;FCFA</span>
                                    @if ($selectedProduct->original_price && $selectedProduct->price < $selectedProduct->original_price)
                                        <span class="text-lg md:text-2xl text-gray-500 line-through">{{ number_format($selectedProduct->original_price, 0, ',', ' ') }}&nbsp;FCFA</span>
                                        <span class="bg-red-500 text-white px-2 md:px-3 py-1 rounded-full text-xs md:text-sm font-bold">
                                            -{{ $selectedProduct->discount_percentage }}%
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Description --}}
                            @if ($selectedProduct->short_description)
                                <div class="bg-pink-50 rounded-2xl p-4 md:p-6">
                                    <h3 class="font-semibold text-pink-900 mb-3 flex items-center text-sm md:text-base">
                                        <span class="w-5 h-5 md:w-6 md:h-6 bg-pink-200 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-xs">📝</span>
                                        </span>
                                        Description
                                    </h3>
                                    <p class="text-pink-800 text-sm md:text-base">{{ $selectedProduct->short_description }}</p>
                                </div>
                            @endif

                            {{-- Caractéristiques beauté RESPONSIVE --}}
                            <div class="grid grid-cols-2 gap-3 md:gap-4">
                                @if ($selectedProduct->skin_type)
                                    <div class="bg-rose-50 rounded-xl md:rounded-2xl p-3 md:p-4 text-center">
                                        <div class="text-xl md:text-2xl mb-2">🌟</div>
                                        <span class="text-xs md:text-sm text-rose-600 font-medium">Type de Peau</span>
                                        <p class="font-bold text-rose-900 text-sm md:text-base">{{ $selectedProduct->skin_type }}</p>
                                    </div>
                                @endif

                                @if ($selectedProduct->volume)
                                    <div class="bg-orange-50 rounded-xl md:rounded-2xl p-3 md:p-4 text-center">
                                        <div class="text-xl md:text-2xl mb-2">📏</div>
                                        <span class="text-xs md:text-sm text-orange-600 font-medium">Volume</span>
                                        <p class="font-bold text-orange-900 text-sm md:text-base">{{ $selectedProduct->volume }}</p>
                                    </div>
                                @endif

                                @if ($selectedProduct->brand->name)
                                    <div class="bg-pink-50 rounded-xl md:rounded-2xl p-3 md:p-4 text-center">
                                        <div class="text-xl md:text-2xl mb-2">✨</div>
                                        <span class="text-xs md:text-sm text-pink-600 font-medium">Marque</span>
                                        <p class="font-bold text-pink-900 text-sm md:text-base">{{ $selectedProduct->brand->name }}</p>
                                    </div>
                                @endif

                                @if ($selectedProduct->category->name)
                                    <div class="bg-rose-50 rounded-xl md:rounded-2xl p-3 md:p-4 text-center">
                                        <div class="text-xl md:text-2xl mb-2">💄</div>
                                        <span class="text-xs md:text-sm text-rose-600 font-medium">Catégorie</span>
                                        <p class="font-bold text-rose-900 text-sm md:text-base">{{ $selectedProduct->category->name }}</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Conseils d'utilisation ou ingrédients --}}
                            @if ($selectedProduct->ingredients || $selectedProduct->usage_tips)
                                <div class="bg-gradient-to-r from-pink-50 to-orange-50 rounded-2xl p-4 md:p-6">
                                    <h3 class="font-semibold text-gray-900 mb-4 flex items-center text-sm md:text-base">
                                        <span class="w-5 h-5 md:w-6 md:h-6 bg-pink-200 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-xs">💡</span>
                                        </span>
                                        Informations Produit
                                    </h3>
                                    <div class="space-y-3">
                                        @if ($selectedProduct->ingredients)
                                            <div class="flex items-start space-x-3">
                                                <span class="text-xs md:text-sm font-semibold text-pink-600 min-w-[80px] md:min-w-[100px]">Ingrédients:</span>
                                                <span class="text-xs md:text-sm text-gray-700 flex-1">{{ $selectedProduct->ingredients }}</span>
                                            </div>
                                        @endif
                                        @if ($selectedProduct->usage_tips)
                                            <div class="flex items-start space-x-3">
                                                <span class="text-xs md:text-sm font-semibold text-orange-600 min-w-[80px] md:min-w-[100px]">Utilisation:</span>
                                                <span class="text-xs md:text-sm text-gray-700 flex-1">{{ $selectedProduct->usage_tips }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- Stock et évaluations --}}
                            <div class="flex items-center justify-between py-4 border-t border-pink-200">
                                <div class="flex items-center space-x-4">
                                    @if ($selectedProduct->is_in_stock)
                                        <span class="inline-flex items-center px-3 md:px-4 py-1 md:py-2 rounded-full text-xs md:text-sm font-semibold bg-emerald-100 text-emerald-800">
                                            ✅ En stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 md:px-4 py-1 md:py-2 rounded-full text-xs md:text-sm font-semibold bg-red-100 text-red-800">
                                            ❌ Rupture
                                        </span>
                                    @endif
                                </div>

                                @if ($selectedProduct->rating_average > 0)
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 md:w-5 md:h-5 {{ $i <= $selectedProduct->rating_average ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-xs md:text-sm text-gray-500">({{ $selectedProduct->reviews_count }} avis)</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions RESPONSIVE --}}
                            <div class="space-y-3 md:space-y-4">
                                @if ($selectedProduct->is_in_stock)
                                    <button wire:click="addToCart({{ $selectedProduct->id }})"
                                        class="w-full py-3 md:py-4 px-4 md:px-6 rounded-xl md:rounded-2xl font-bold text-white text-base md:text-lg transition-all transform hover:scale-105 shadow-xl hover:shadow-2xl bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600">
                                        🛒 Ajouter au panier
                                    </button>
                                @else
                                    <button disabled
                                        class="w-full bg-gray-300 text-gray-500 py-3 md:py-4 px-4 md:px-6 rounded-xl md:rounded-2xl font-bold text-base md:text-lg cursor-not-allowed">
                                        Produit indisponible
                                    </button>
                                @endif

                                <div class="grid grid-cols-2 gap-3 md:gap-4">
                                    <button wire:click="toggleWishlist({{ $selectedProduct->id }})"
                                        class="flex items-center justify-center space-x-2 py-2 md:py-3 px-3 md:px-4 rounded-lg md:rounded-xl border-2 border-pink-300 hover:border-red-500 hover:text-red-500 transition-all text-sm md:text-base">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        <span>Favoris</span>
                                    </button>

                                    <button wire:click="contactWhatsApp({{ $selectedProduct->id }})"
                                        class="flex items-center justify-center space-x-2 py-2 md:py-3 px-3 md:px-4 rounded-lg md:rounded-xl bg-green-500 text-white hover:bg-green-600 transition-all text-sm md:text-base">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106" />
                                        </svg>
                                        <span>Contact</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Scripts SIMPLIFIÉS (identiques à Parfums mais adaptés beauté) --}}
@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            console.log('🚀 Livewire Beauté initialisé');

            // ✅ ÉCOUTEUR WHATSAPP (identique à Dashboar et Parfums)
            Livewire.on('open-whatsapp', (event) => {
                console.log('📱 Événement WhatsApp reçu:', event);
                
                let url = null;

                // Format 1: event.url directement
                if (event && event.url) {
                    url = event.url;
                    console.log('✅ URL trouvée (format 1):', url);
                }
                // Format 2: premier élément si c'est un tableau
                else if (Array.isArray(event) && event.length > 0 && event[0].url) {
                    url = event[0].url;
                    console.log('✅ URL trouvée (format 2):', url);
                }
                // Format 3: event direct si c'est une string
                else if (typeof event === 'string' && event.startsWith('http')) {
                    url = event;
                    console.log('✅ URL trouvée (format 3):', url);
                }

                if (!url) {
                    console.error('❌ Aucune URL trouvée dans:', event);
                    alert('Erreur: URL WhatsApp non disponible.\nConsultez la console pour plus de détails.');
                    return;
                }

                console.log('🔗 URL finale à ouvrir:', url);

                // ✅ OUVERTURE WHATSAPP (même logique que Dashboar)
                try {
                    const popup = window.open(url, '_blank', 'noopener,noreferrer');

                    setTimeout(() => {
                        if (!popup || popup.closed) {
                            console.warn('⚠️ Popup bloquée, redirection...');
                            window.location.href = url;
                        }
                    }, 1000);

                } catch (error) {
                    console.error('❌ Erreur ouverture:', error);
                    const copy = confirm('Impossible d\'ouvrir WhatsApp.\nVoulez-vous copier le lien ?');
                    if (copy) {
                        navigator.clipboard.writeText(url).then(() => {
                            alert('✅ Lien copié !');
                        }).catch(() => {
                            prompt('Copiez ce lien:', url);
                        });
                    }
                }
            });

            // ✅ GESTION MODAL avec scroll automatique (CORRIGÉ)
            Livewire.on('modal-opened', () => {
                console.log('💄 Modal beauté ouverte - scroll vers le haut');
                // Scroll immédiat vers le haut
                window.scrollTo({ top: 0, behavior: 'smooth' });
                
                // S'assurer que la modal est visible après l'animation
                setTimeout(() => {
                    const modal = document.getElementById('modal-overlay');
                    if (modal) {
                        modal.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }, 100);
            });

            Livewire.on('modal-closed', () => {
                console.log('💄 Modal beauté fermée');
                // Ne pas modifier le scroll, laisser l'utilisateur où il était
            });

            // ✅ NOTIFICATION PANIER (identique à Dashboar)
            Livewire.on('cart-updated', () => {
                showCartNotification();
                
                // Son de notification
                try {
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();
                    
                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);
                    
                    oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                    oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.1);
                    
                    gainNode.gain.setValueAtTime(0, audioContext.currentTime);
                    gainNode.gain.linearRampToValueAtTime(0.1, audioContext.currentTime + 0.05);
                    gainNode.gain.linearRampToValueAtTime(0, audioContext.currentTime + 0.2);
                    
                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 0.2);
                } catch (e) {
                    console.log('Audio notification non supportée');
                }
            });

            Livewire.on('hide-cart-success', () => {
                hideCartNotification();
            });
        });

        // ✅ SYSTÈME DE NOTIFICATION (identique à Dashboar et Parfums)
        let currentNotification = null;
        let notificationTimer = null;
        let progressTimer = null;

        function showCartNotification() {
            hideCartNotification();
            
            const notificationElement = document.getElementById('cart-notification');
            const message = notificationElement ? notificationElement.dataset.message : 'Produit beauté ajouté au panier !';
            
            currentNotification = document.createElement('div');
            currentNotification.className = 'cart-toast-notification';
            currentNotification.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-bold text-white text-base">💄 Produit ajouté !</h4>
                            <button onclick="hideCartNotification()" class="text-white/80 hover:text-white transition-colors p-1 hover:bg-white/10 rounded close-btn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-white/90 text-sm font-medium mb-3">${message}</p>
                        <div class="flex items-center space-x-3 mb-3">
                            <a href="/panier" class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg font-medium transition-colors">
                                🛒 Voir le panier
                            </a>
                            <button onclick="hideCartNotification()" class="text-xs bg-white/10 hover:bg-white/20 text-white px-3 py-1.5 rounded-lg font-medium transition-colors">
                                ✕ Fermer
                            </button>
                        </div>
                        <div class="text-xs text-white/70 mb-2 flex items-center justify-between">
                            <span>Fermeture dans <span class="time-left">6</span>s</span>
                            <span class="opacity-50 progress-percent">100%</span>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-1">
                            <div class="bg-white rounded-full h-1 transition-all duration-100 progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(currentNotification);
            
            if (navigator.vibrate) {
                navigator.vibrate([100, 50, 100]);
            }
            
            setTimeout(() => {
                currentNotification.classList.add('show');
            }, 50);
            
            let timeLeft = 6;
            let progress = 100;
            
            notificationTimer = setTimeout(() => {
                hideCartNotification();
            }, 6000);
            
            progressTimer = setInterval(() => {
                timeLeft = Math.max(0, timeLeft - 0.1);
                progress = Math.max(0, (timeLeft / 6) * 100);
                
                const timeLeftElement = currentNotification.querySelector('.time-left');
                const progressBarElement = currentNotification.querySelector('.progress-bar');
                const progressPercentElement = currentNotification.querySelector('.progress-percent');
                
                if (timeLeftElement) {
                    timeLeftElement.textContent = Math.ceil(timeLeft);
                }
                if (progressBarElement) {
                    progressBarElement.style.width = progress + '%';
                }
                if (progressPercentElement) {
                    progressPercentElement.textContent = Math.round(progress) + '%';
                }
                
                if (timeLeft <= 0) {
                    clearInterval(progressTimer);
                }
            }, 100);
        }

        function hideCartNotification() {
            if (currentNotification) {
                currentNotification.classList.add('hide');
                
                setTimeout(() => {
                    if (currentNotification && currentNotification.parentNode) {
                        currentNotification.parentNode.removeChild(currentNotification);
                    }
                    currentNotification = null;
                }, 300);
            }
            
            if (notificationTimer) {
                clearTimeout(notificationTimer);
                notificationTimer = null;
            }
            if (progressTimer) {
                clearInterval(progressTimer);
                progressTimer = null;
            }
            
            if (window.Livewire) {
                Livewire.dispatch('hide-cart-success');
            }
        }

        // ✅ FONCTION SLIDERS (couleurs rose/orange)
        function initializeSliders() {
            const sliders = document.querySelectorAll('.pink-slider');
            sliders.forEach(slider => {
                updateSliderBackground(slider);
                
                slider.addEventListener('input', function() {
                    updateSliderBackground(this);
                });
                
                slider.addEventListener('change', function() {
                    updateSliderBackground(this);
                });
            });
        }

        function updateSliderBackground(slider) {
            const percentage = (slider.value - slider.min) / (slider.max - slider.min) * 100;
            slider.style.background = `linear-gradient(to right, #EC4899 0%, #EC4899 ${percentage}%, #e2e8f0 ${percentage}%, #e2e8f0 100%)`;
        }

        // ✅ INITIALISATION
        document.addEventListener('DOMContentLoaded', function() {
            initializeSliders();
            document.addEventListener('livewire:navigated', initializeSliders);
            Livewire.hook('morph.updated', initializeSliders);
        });
    </script>
@endpush

{{-- Styles AMÉLIORÉS (identiques aux parfums mais couleurs rose/orange) --}}
@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Slider beauté personnalisé (couleurs rose/orange) */
        .pink-slider::-webkit-slider-thumb {
            appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #EC4899 0%, #F97316 100%);
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.4);
            border: 2px solid white;
        }

        .pink-slider::-moz-range-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #EC4899 0%, #F97316 100%);
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.4);
        }

        .pink-slider:focus::-webkit-slider-thumb {
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
        }

        /* ✅ NOTIFICATION TOAST (identique à Parfums et Dashboar mais couleurs beauté) */
        .cart-toast-notification {
            position: fixed !important;
            top: 20px !important;
            right: 20px !important;
            z-index: 2147483647 !important;
            max-width: 400px !important;
            width: calc(100vw - 40px) !important;
            background: linear-gradient(135deg, #EC4899, #F97316) !important;
            color: white !important;
            padding: 1.5rem !important;
            border-radius: 1rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 
                        0 0 0 1px rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(8px) !important;
            pointer-events: auto !important;
            cursor: pointer !important;
            isolation: isolate !important;
            contain: layout style paint !important;
            will-change: transform !important;
            transform: translateY(-120%) scale(0.9) !important;
            opacity: 0 !important;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }

        .cart-toast-notification.show {
            transform: translateY(0) scale(1) !important;
            opacity: 1 !important;
        }

        .cart-toast-notification.hide {
            transform: translateY(-120%) scale(0.9) !important;
            opacity: 0 !important;
            transition: all 0.2s ease-in !important;
        }

        @media (min-width: 768px) {
            .cart-toast-notification {
                width: 400px !important;
            }
        }

        @media (max-width: 640px) {
            .cart-toast-notification {
                top: 10px !important;
                right: 10px !important;
                left: 10px !important;
                width: calc(100vw - 20px) !important;
                max-width: none !important;
            }
        }

        .cart-toast-notification:hover {
            transform: translateY(0) scale(1.02) !important;
            box-shadow: 0 32px 64px -12px rgba(0, 0, 0, 0.35) !important;
        }

        .cart-toast-notification .close-btn:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        .cart-toast-notification .progress-bar {
            background: rgba(255, 255, 255, 0.9) !important;
            border-radius: 2px !important;
        }

        .cart-notification-hidden {
            display: none !important;
        }

        /* ✅ MODAL AMÉLIORÉE */
        @media (max-width: 768px) {
            .line-clamp-2 {
                -webkit-line-clamp: 3;
            }
        }

        #modal-overlay {
            scroll-behavior: smooth;
        }

        /* ✅ ACCESSIBILITÉ (couleurs beauté) */
        button:focus, 
        input:focus, 
        select:focus {
            outline: 2px solid #EC4899;
            outline-offset: 2px;
        }

        body {
            overflow-y: auto !important;
        }

        /* ✅ ANIMATIONS */
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: translateY(-100%) scale(0.3);
            }
            50% {
                opacity: 1;
                transform: translateY(10%) scale(1.05);
            }
            70% {
                transform: translateY(-5%) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0%) scale(1);
            }
        }

        .cart-toast-notification {
            animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .progress-bar {
            transition: width 0.1s linear;
            animation: pulse 2s infinite;
        }
    </style>
@endpush