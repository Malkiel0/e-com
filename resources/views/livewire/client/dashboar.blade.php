<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white">
    {{-- Header avec recherche et filtres --}}
    <div class="bg-white/80 backdrop-blur-sm z-40 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
                {{-- Titre et statistiques --}}
                <div class="text-center lg:text-left">
                    <h1
                        class="text-3xl lg:text-4xl font-display font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        ✨ Tous nos Produits
                    </h1>
                    <p class="text-gray-600 mt-2">{{ $products->total() }} produits de beauté et parfums d'exception</p>
                </div>

                {{-- Barre de recherche --}}
                <div class="w-full lg:w-96">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Rechercher un produit, une marque..."
                            class="w-full pl-12 pr-4 py-3 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none bg-white/70 backdrop-blur-sm">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        @if ($search)
                            <button wire:click="$set('search', '')"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Bouton filtres mobile --}}
                <button wire:click="$toggle('showFilters')"
                    class="lg:hidden bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-3 rounded-2xl font-semibold flex items-center space-x-2 hover:from-purple-600 hover:to-pink-600 transition-all transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                    <span>Filtres</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Message de succès panier --}}
    @if ($showCartSuccess)
        <div class="fixed top-24 right-6 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 transform transition-all duration-500 ease-out"
            x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-semibold">{{ $cartMessage }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Sidebar Filtres --}}
            <div class="lg:w-80 {{ $showFilters ? 'block' : 'hidden lg:block' }}">
                <div
                    class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 shadow-xl border border-white/20 sticky top-32">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                            </path>
                        </svg>
                        Filtres
                    </h3>

                    {{-- Catégories --}}
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-800 mb-4">🌸 Catégories</h4>
                        <select wire:model.live="selectedCategory"
                            class="w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none bg-white/70">
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
                        <h4 class="font-semibold text-gray-800 mb-4">💄 Marques</h4>
                        <select wire:model.live="selectedBrand"
                            class="w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none bg-white/70">
                            <option value="">Toutes les marques</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Prix --}}
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-800 mb-4">💰 Prix</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm text-gray-600">Prix minimum: {{ $minPrice }}€</label>
                                <input type="range" wire:model.live="minPrice" min="0"
                                    max="{{ $maxPrice }}"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Prix maximum: {{ $maxPrice }}€</label>
                                <input type="range" wire:model.live="maxPrice" min="{{ $minPrice }}"
                                    max="1000"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                            </div>
                        </div>
                    </div>

                    {{-- Tri --}}
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 mb-4">📊 Trier par</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <button wire:click="sortBy('name')"
                                class="p-3 rounded-xl text-sm font-medium transition-all {{ $sortBy === 'name' ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Nom {{ $sortBy === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                            </button>
                            <button wire:click="sortBy('price')"
                                class="p-3 rounded-xl text-sm font-medium transition-all {{ $sortBy === 'price' ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Prix {{ $sortBy === 'price' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                            </button>
                            <button wire:click="sortBy('rating')"
                                class="p-3 rounded-xl text-sm font-medium transition-all {{ $sortBy === 'rating' ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Note {{ $sortBy === 'rating' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                            </button>
                            <button wire:click="sortBy('sales')"
                                class="p-3 rounded-xl text-sm font-medium transition-all {{ $sortBy === 'sales' ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Ventes {{ $sortBy === 'sales' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                            </button>
                        </div>
                    </div>

                    {{-- Bouton reset filtres --}}
                    <button
                        wire:click="$set('search', ''); $set('selectedCategory', ''); $set('selectedBrand', ''); $set('minPrice', 0); $set('maxPrice', 1000)"
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-medium transition-all">
                        🔄 Réinitialiser
                    </button>
                </div>
            </div>

            {{-- Grille Produits --}}
            <div class="flex-1">
                {{-- En-tête résultats --}}
                <div class="flex items-center justify-between mb-6">
                    <p class="text-gray-600">
                        <span class="font-semibold text-gray-900">{{ $products->total() }}</span> produits trouvés
                    </p>
                    <div class="flex items-center space-x-4">
                        {{-- Mode d'affichage --}}
                        <div class="flex items-center space-x-1 bg-gray-100 rounded-lg p-1">
                            <button wire:click="$set('viewMode', 'grid')"
                                class="p-2 rounded-md {{ $viewMode === 'grid' ? 'bg-white shadow-sm text-purple-600' : 'text-gray-600' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                            </button>
                            <button wire:click="$set('viewMode', 'list')"
                                class="p-2 rounded-md {{ $viewMode === 'list' ? 'bg-white shadow-sm text-purple-600' : 'text-gray-600' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Grille/Liste des produits --}}
                @if ($products->count() > 0)
                    <div
                        class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8' : 'space-y-6' }}">
                        @foreach ($products as $product)
                            <div class="product-card group" data-product-id="{{ $product->id }}"
                                x-data="{
                                    inWishlist: {{ in_array($product->id, $userWishlist) ? 'true' : 'false' }},
                                    loading: false
                                }">

                                @if ($viewMode === 'grid')
                                    {{-- Vue grille --}}
                                    <div
                                        class="bg-white/70 backdrop-blur-sm rounded-3xl overflow-hidden shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 hover:scale-105">
                                        {{-- Image produit --}}
                                        <div class="relative aspect-square overflow-hidden cursor-pointer"
                                            wire:click="viewProduct({{ $product->id }})">

                                            @if ($product->primaryImage)
                                                <img src="{{ asset('storage/' . $product->primaryImage->file_path) }}"
                                                    alt="{{ $product->name }}"
                                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                    loading="lazy">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'from-purple-100 to-purple-200' : 'from-pink-100 to-pink-200' }} flex items-center justify-center">
                                                    <span class="text-6xl">
                                                        {{ strpos(strtolower($product->category->name), 'parfum') !== false ? '🌸' : '💄' }}
                                                    </span>
                                                </div>
                                            @endif

                                            {{-- Badges --}}
                                            <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                                @if ($product->is_new)
                                                    <span
                                                        class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                                        ✨ NOUVEAU
                                                    </span>
                                                @endif
                                                @if ($product->original_price && $product->price < $product->original_price)
                                                    <span
                                                        class="bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                                        -{{ $product->discount_percentage }}%
                                                    </span>
                                                @endif
                                                @if ($product->is_bestseller)
                                                    <span
                                                        class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                                        🔥 TOP
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Actions --}}
                                            <div
                                                class="absolute top-4 right-4 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                {{-- Favoris --}}
                                                <button wire:click.stop="toggleWishlist({{ $product->id }})"
                                                    :class="inWishlist ? 'bg-red-500 text-white' : 'bg-white/90 text-gray-600'"
                                                    class="w-10 h-10 backdrop-blur-sm rounded-full flex items-center justify-center hover:scale-110 transition-all shadow-lg">
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
                                                    class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-purple-600 hover:scale-110 transition-all shadow-lg">
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
                                                    class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center hover:scale-110 transition-all shadow-lg">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Informations produit --}}
                                        <div class="p-6">
                                            {{-- Marque --}}
                                            <p class="text-sm font-medium mb-2"
                                                style="color: {{ strpos(strtolower($product->category->name), 'parfum') !== false ? '#8B5CF6' : '#EC4899' }}">
                                                {{ $product->brand->name }}
                                            </p>

                                            {{-- Nom --}}
                                            <h3 class="font-bold text-gray-900 text-lg mb-3 line-clamp-2 cursor-pointer hover:text-purple-600 transition-colors"
                                                wire:click="viewProduct({{ $product->id }})">
                                                {{ $product->name }}
                                            </h3>

                                            {{-- Prix --}}
                                            <div class="flex items-center space-x-2 mb-4">
                                                <span
                                                    class="text-2xl font-bold text-gray-900">{{ $product->price }}€</span>
                                                @if ($product->original_price && $product->price < $product->original_price)
                                                    <span
                                                        class="text-lg text-gray-500 line-through">{{ $product->original_price }}€</span>
                                                @endif
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
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                        ✅ En stock
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
                                                    class="w-full py-3 px-4 rounded-2xl font-semibold text-white transition-all transform hover:scale-105 shadow-lg hover:shadow-xl"
                                                    style="background: {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%)' : 'linear-gradient(135deg, #EC4899 0%, #F97316 100%)' }}"
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
                                    {{-- Vue liste --}}
                                    <div
                                        class="bg-white/70 backdrop-blur-sm rounded-3xl overflow-hidden shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-300">
                                        <div class="flex flex-col md:flex-row">
                                            {{-- Image --}}
                                            <div class="md:w-48 h-48 relative overflow-hidden cursor-pointer"
                                                wire:click="viewProduct({{ $product->id }})">
                                                @if ($product->primaryImage)
                                                    <img src="{{ asset('storage/' . $product->primaryImage->file_path) }}"
                                                        alt="{{ $product->name }}"
                                                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                                                        loading="lazy">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-gradient-to-br {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'from-purple-100 to-purple-200' : 'from-pink-100 to-pink-200' }} flex items-center justify-center">
                                                        <span class="text-4xl">
                                                            {{ strpos(strtolower($product->category->name), 'parfum') !== false ? '🌸' : '💄' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Contenu --}}
                                            <div class="flex-1 p-6">
                                                <div
                                                    class="flex flex-col md:flex-row md:items-center justify-between h-full">
                                                    <div class="flex-1">
                                                        {{-- Marque et catégorie --}}
                                                        <div class="flex items-center space-x-3 mb-2">
                                                            <span class="text-sm font-medium"
                                                                style="color: {{ strpos(strtolower($product->category->name), 'parfum') !== false ? '#8B5CF6' : '#EC4899' }}">
                                                                {{ $product->brand->name }}
                                                            </span>
                                                            <span
                                                                class="text-xs text-gray-500">{{ $product->category->name }}</span>
                                                        </div>

                                                        {{-- Nom --}}
                                                        <h3 class="font-bold text-xl text-gray-900 mb-2 cursor-pointer hover:text-purple-600 transition-colors"
                                                            wire:click="viewProduct({{ $product->id }})">
                                                            {{ $product->name }}
                                                        </h3>

                                                        {{-- Description courte --}}
                                                        @if ($product->short_description)
                                                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                                                {{ $product->short_description }}
                                                            </p>
                                                        @endif

                                                        {{-- Note et badges --}}
                                                        <div class="flex items-center space-x-4 mb-3">
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

                                                            <div class="flex space-x-2">
                                                                @if ($product->is_new)
                                                                    <span
                                                                        class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                                        ✨ NOUVEAU
                                                                    </span>
                                                                @endif
                                                                @if ($product->is_bestseller)
                                                                    <span
                                                                        class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                                        🔥 TOP
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Prix et actions --}}
                                                    <div class="md:text-right md:ml-6">
                                                        {{-- Prix --}}
                                                        <div class="mb-4">
                                                            <div
                                                                class="flex md:flex-col items-center md:items-end space-x-2 md:space-x-0">
                                                                <span
                                                                    class="text-2xl font-bold text-gray-900">{{ $product->price }}€</span>
                                                                @if ($product->original_price && $product->price < $product->original_price)
                                                                    <div class="md:mt-1">
                                                                        <span
                                                                            class="text-lg text-gray-500 line-through">{{ $product->original_price }}€</span>
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
                                                                    class="flex-1 md:w-auto py-2 px-4 rounded-xl font-semibold text-white transition-all transform hover:scale-105"
                                                                    style="background: {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%)' : 'linear-gradient(135deg, #EC4899 0%, #F97316 100%)' }}">
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
                                                                        'bg-gray-100 text-gray-600'"
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
                    {{-- Aucun produit --}}
                    <div class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <div class="text-6xl mb-6">🔍</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun produit trouvé</h3>
                            <p class="text-gray-600 mb-6">
                                Nous n'avons trouvé aucun produit correspondant à vos critères de recherche.
                                Essayez de modifier vos filtres ou votre recherche.
                            </p>
                            <button
                                wire:click="$set('search', ''); $set('selectedCategory', ''); $set('selectedBrand', ''); $set('minPrice', 0); $set('maxPrice', 1000)"
                                class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-8 py-3 rounded-2xl font-semibold transition-all transform hover:scale-105">
                                🔄 Réinitialiser les filtres
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Quick View --}}
    @if ($showQuickView && $selectedProduct)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            x-data="{ show: @entangle('showQuickView') }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            @click.self="$wire.closeQuickView()">

            <div class="bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                {{-- Header modal --}}
                <div class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-gray-200 p-6 rounded-t-3xl z-10">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900">Aperçu rapide</h2>
                        <button wire:click="closeQuickView"
                            class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Contenu modal --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {{-- Images --}}
                        <div class="space-y-4">
                            {{-- Image principale --}}
                            <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100">
                                @if ($selectedProduct->primaryImage)
                                    <img src="{{ asset('storage/' . $selectedProduct->primaryImage->file_path) }}"
                                        alt="{{ $selectedProduct->name }}" class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br {{ strpos(strtolower($selectedProduct->category->name), 'parfum') !== false ? 'from-purple-100 to-purple-200' : 'from-pink-100 to-pink-200' }} flex items-center justify-center">
                                        <span class="text-8xl">
                                            {{ strpos(strtolower($selectedProduct->category->name), 'parfum') !== false ? '🌸' : '💄' }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Galerie thumbnails --}}
                            @if ($selectedProduct->images->count() > 1)
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach ($selectedProduct->images->take(4) as $image)
                                        <div
                                            class="aspect-square rounded-lg overflow-hidden bg-gray-100 cursor-pointer hover:opacity-75 transition-opacity">
                                            <img src="{{ asset('storage/' . $image->file_path) }}"
                                                alt="{{ $selectedProduct->name }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Informations --}}
                        <div class="space-y-6">
                            {{-- En-tête produit --}}
                            <div>
                                <div class="flex items-center space-x-3 mb-2">
                                    <span class="text-lg font-semibold"
                                        style="color: {{ strpos(strtolower($selectedProduct->category->name), 'parfum') !== false ? '#8B5CF6' : '#EC4899' }}">
                                        {{ $selectedProduct->brand->name }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $selectedProduct->category->name }}</span>
                                </div>

                                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $selectedProduct->name }}</h1>

                                {{-- Prix --}}
                                <div class="flex items-center space-x-3 mb-6">
                                    <span
                                        class="text-3xl font-bold text-gray-900">{{ $selectedProduct->price }}€</span>
                                    @if ($selectedProduct->original_price && $selectedProduct->price < $selectedProduct->original_price)
                                        <span
                                            class="text-xl text-gray-500 line-through">{{ $selectedProduct->original_price }}€</span>
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                            -{{ $selectedProduct->discount_percentage }}%
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Description --}}
                            @if ($selectedProduct->short_description)
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                                    <p class="text-gray-600">{{ $selectedProduct->short_description }}</p>
                                </div>
                            @endif

                            {{-- Caractéristiques spécifiques --}}
                            <div class="grid grid-cols-2 gap-4">
                                @if ($selectedProduct->volume)
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <span class="text-sm text-gray-500">Volume</span>
                                        <p class="font-semibold">{{ $selectedProduct->volume }}</p>
                                    </div>
                                @endif

                                @if ($selectedProduct->concentration)
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <span class="text-sm text-gray-500">Concentration</span>
                                        <p class="font-semibold">{{ $selectedProduct->concentration }}</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Notes olfactives --}}
                            @if ($selectedProduct->fragrance_notes)
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-3">🌸 Notes olfactives</h3>
                                    <div class="space-y-2">
                                        @foreach ($selectedProduct->fragrance_notes as $noteType => $notes)
                                            <div class="flex items-start space-x-3">
                                                <span
                                                    class="text-sm font-medium text-gray-500 min-w-[80px] capitalize">{{ $noteType }}:</span>
                                                <span
                                                    class="text-sm text-gray-700">{{ is_array($notes) ? implode(', ', $notes) : $notes }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Stock et évaluations --}}
                            <div class="flex items-center justify-between py-4 border-t border-gray-200">
                                <div class="flex items-center space-x-4">
                                    @if ($selectedProduct->is_in_stock)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            ✅ En stock
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                            ❌ Rupture
                                        </span>
                                    @endif
                                </div>

                                @if ($selectedProduct->rating_average > 0)
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $selectedProduct->rating_average ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-500">({{ $selectedProduct->reviews_count }}
                                            avis)</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="space-y-4">
                                @if ($selectedProduct->is_in_stock)
                                    <button wire:click="addToCart({{ $selectedProduct->id }})"
                                        class="w-full py-4 px-6 rounded-2xl font-bold text-white text-lg transition-all transform hover:scale-105 shadow-lg hover:shadow-xl"
                                        style="background: {{ strpos(strtolower($selectedProduct->category->name), 'parfum') !== false ? 'linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%)' : 'linear-gradient(135deg, #EC4899 0%, #F97316 100%)' }}">
                                        🛒 Ajouter au panier
                                    </button>
                                @else
                                    <button disabled
                                        class="w-full bg-gray-300 text-gray-500 py-4 px-6 rounded-2xl font-bold text-lg cursor-not-allowed">
                                        Produit indisponible
                                    </button>
                                @endif

                                <div class="grid grid-cols-2 gap-4">
                                    <button wire:click="toggleWishlist({{ $selectedProduct->id }})"
                                        class="flex items-center justify-center space-x-2 py-3 px-4 rounded-xl border-2 border-gray-300 hover:border-red-500 hover:text-red-500 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        <span>Favoris</span>
                                    </button>

                                    <button wire:click="contactWhatsApp({{ $selectedProduct->id }})"
                                        class="flex items-center justify-center space-x-2 py-3 px-4 rounded-xl bg-green-500 text-white hover:bg-green-600 transition-all">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106" />
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
    @endif
</div>

{{-- Scripts spéciaux --}}
@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            console.log('🚀 Livewire initialisé');

            // ✅ ÉCOUTEUR WHATSAPP ROBUSTE
            Livewire.on('open-whatsapp', (event) => {
                console.log('📱 Événement WhatsApp reçu:', event);
                console.log('📱 Type de l\'événement:', typeof event);
                console.log('📱 Contenu brut:', JSON.stringify(event));

                // ✅ GESTION MULTI-FORMAT
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
                    alert(
                        'Erreur: URL WhatsApp non disponible.\nConsultez la console pour plus de détails.');
                    return;
                }

                console.log('🔗 URL finale à ouvrir:', url);

                // ✅ OUVERTURE WHATSAPP
                try {
                    // Méthode 1: Popup
                    const popup = window.open(url, '_blank', 'noopener,noreferrer');

                    setTimeout(() => {
                        if (!popup || popup.closed) {
                            console.warn('⚠️ Popup bloquée, redirection...');
                            // Méthode 2: Redirection
                            window.location.href = url;
                        }
                    }, 1000);

                } catch (error) {
                    console.error('❌ Erreur ouverture:', error);
                    // Méthode 3: Fallback manuel
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
        });

        // ✅ TEST DIRECT (temporaire)
        function testWhatsAppDirect() {
            const testUrl = 'https://wa.me/2290190927406?text=Test%20direct';
            console.log('🧪 Test direct:', testUrl);
            window.open(testUrl, '_blank');
        }

        // Slider de prix (inchangé)
        document.addEventListener('DOMContentLoaded', function() {
            const sliders = document.querySelectorAll('.slider');
            sliders.forEach(slider => {
                slider.style.background =
                    `linear-gradient(to right, #8B5CF6 0%, #8B5CF6 ${(slider.value - slider.min) / (slider.max - slider.min) * 100}%, #e5e7eb ${(slider.value - slider.min) / (slider.max - slider.min) * 100}%, #e5e7eb 100%)`;

                slider.addEventListener('input', function() {
                    this.style.background =
                        `linear-gradient(to right, #8B5CF6 0%, #8B5CF6 ${(this.value - this.min) / (this.max - this.min) * 100}%, #e5e7eb ${(this.value - this.min) / (this.max - this.min) * 100}%, #e5e7eb 100%)`;
                });
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

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Slider personnalisé */
        .slider::-webkit-slider-thumb {
            appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #8B5CF6;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3);
        }

        .slider::-moz-range-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #8B5CF6;
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3);
        }
    </style>
@endpush
