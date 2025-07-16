<div class="min-h-screen bg-gradient-to-br {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'from-purple-50 via-indigo-50 to-blue-50' : 'from-pink-50 via-rose-50 to-orange-50' }}">
    {{-- Message de succès panier --}}
    @if($showCartSuccess)
        <div class="fixed top-6 right-6 bg-gradient-to-r {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'from-purple-500 to-indigo-600' : 'from-pink-500 to-orange-500' }} text-white px-6 py-4 rounded-2xl shadow-2xl z-50 transform transition-all duration-500 ease-out"
             x-data="{ show: true }" 
             x-show="show"
             x-transition:enter="transform ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-semibold">{{ $cartMessage }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- Fil d'Ariane --}}
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li>
                    <a href="{{ route('dashboard') }}" class="hover:text-purple-600 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Accueil
                    </a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ strpos(strtolower($product->category->name), 'parfum') !== false ? route('parfums') : route('produitsDeBeauté') }}" 
                       class="hover:{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'text-purple-600' : 'text-pink-600' }} transition-colors">
                        {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'Parfums' : 'Beauté' }}
                    </a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-gray-900 font-medium">{{ $product->name }}</span>
                </li>
            </ol>
        </nav>

        {{-- Contenu principal produit --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            {{-- Galerie d'images --}}
            <div class="space-y-6">
                {{-- Image principale --}}
                <div class="relative aspect-square rounded-3xl overflow-hidden bg-white shadow-2xl group"
                     x-data="{ imageLoaded: false }">
                    @if($product->images->count() > 0)
                        <img src="{{ Storage::url($product->images[$selectedImageIndex]->file_path) }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover cursor-zoom-in transition-transform duration-700 group-hover:scale-110"
                             x-on:load="imageLoaded = true"
                             x-show="imageLoaded"
                             wire:click="showZoom('{{ Storage::url($product->images[$selectedImageIndex]->file_path) }}')">
                        
                        {{-- Loading skeleton --}}
                        <div x-show="!imageLoaded" class="w-full h-full bg-gradient-to-br {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'from-purple-100 to-indigo-100' : 'from-pink-100 to-orange-100' }} flex items-center justify-center">
                            <div class="animate-pulse text-6xl">
                                {{ strpos(strtolower($product->category->name), 'parfum') !== false ? '🌸' : '💄' }}
                            </div>
                        </div>
                    @else
                        <div class="w-full h-full bg-gradient-to-br {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'from-purple-100 to-indigo-100' : 'from-pink-100 to-orange-100' }} flex items-center justify-center">
                            <span class="text-8xl">{{ strpos(strtolower($product->category->name), 'parfum') !== false ? '🌸' : '💄' }}</span>
                        </div>
                    @endif

                    {{-- Badges sur l'image --}}
                    <div class="absolute top-6 left-6 flex flex-wrap gap-3">
                        @if($product->is_new)
                            <span class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                ✨ NOUVEAU
                            </span>
                        @endif
                        @if($product->original_price && $product->price < $product->original_price)
                            <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                -{{ $product->discount_percentage }}%
                            </span>
                        @endif
                        @if($product->is_bestseller)
                            <span class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                🔥 BESTSELLER
                            </span>
                        @endif
                    </div>

                    {{-- Indicateur zoom --}}
                    <div class="absolute bottom-6 right-6 bg-black/60 text-white px-3 py-2 rounded-full text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                        🔍 Cliquer pour zoomer
                    </div>
                </div>

                {{-- Thumbnails --}}
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $index => $image)
                            <button wire:click="selectImage({{ $index }})"
                                    class="aspect-square rounded-xl overflow-hidden {{ $selectedImageIndex === $index ? 'ring-4 ring-' . (strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink') . '-500' : '' }} transition-all hover:scale-105 shadow-lg">
                                <img src="{{ Storage::url($image->file_path) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Informations produit --}}
            <div class="space-y-8">
                {{-- En-tête produit --}}
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="text-lg font-bold {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'text-purple-600' : 'text-pink-600' }} uppercase tracking-wide">
                            {{ $product->brand->name }}
                        </span>
                        <span class="bg-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-50 text-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-700 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $product->category->name }}
                        </span>
                    </div>
                    
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">{{ $product->name }}</h1>
                    
                    {{-- Prix --}}
                    <div class="flex items-center space-x-4 mb-6">
                        <span class="text-4xl font-bold text-gray-900">{{ $product->price }}FCFA</span>
                        @if($product->original_price && $product->price < $product->original_price)
                            <span class="text-2xl text-gray-500 line-through">{{ $product->original_price }}FCFA</span>
                            <span class="bg-red-500 text-white px-4 py-2 rounded-full text-lg font-bold">
                                -{{ $product->discount_percentage }}%
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Évaluations --}}
                @if($product->rating_average > 0)
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-6 h-6 {{ $i <= $product->rating_average ? 'text-yellow-400' : 'text-gray-300' }}" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                                <div>
                                    <span class="text-2xl font-bold text-gray-900">{{ $product->rating_average }}/5</span>
                                    <p class="text-gray-600">({{ $product->reviews_count }} avis)</p>
                                </div>
                            </div>
                            <button wire:click="$toggle('showReviewForm')" 
                                    class="bg-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100 text-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-700 hover:bg-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-200 px-4 py-2 rounded-lg font-medium transition-colors">
                                Laisser un avis
                            </button>
                        </div>
                    </div>
                @endif

                {{-- Description --}}
                @if($product->short_description)
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100">
                        <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                            <span class="w-8 h-8 bg-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm">📝</span>
                            </span>
                            Description
                        </h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->short_description }}</p>
                    </div>
                @endif

                {{-- Caractéristiques --}}
                <div class="grid grid-cols-2 gap-4">
                    @if($product->volume)
                        <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100 text-center">
                            <div class="text-3xl mb-3">🧴</div>
                            <span class="text-sm text-gray-500 font-medium">Volume</span>
                            <p class="font-bold text-gray-900 text-lg">{{ $product->volume }}</p>
                        </div>
                    @endif
                    
                    @if($product->concentration)
                        <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100 text-center">
                            <div class="text-3xl mb-3">💎</div>
                            <span class="text-sm text-gray-500 font-medium">Concentration</span>
                            <p class="font-bold text-gray-900 text-lg">{{ $product->concentration }}</p>
                        </div>
                    @endif

                    @if($product->skin_type)
                        <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100 text-center">
                            <div class="text-3xl mb-3">🌟</div>
                            <span class="text-sm text-gray-500 font-medium">Type de peau</span>
                            <p class="font-bold text-gray-900 text-lg">{{ $product->skin_type }}</p>
                        </div>
                    @endif

                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100 text-center">
                        <div class="text-3xl mb-3">📊</div>
                        <span class="text-sm text-gray-500 font-medium">Popularité</span>
                        <p class="font-bold text-gray-900 text-lg">{{ $product->views_count }} vues</p>
                    </div>
                </div>

                {{-- Notes olfactives --}}
                @if($product->fragrance_notes && strpos(strtolower($product->category->name), 'parfum') !== false)
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-100">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm">🌸</span>
                            </span>
                            Notes olfactives
                        </h3>
                        <div class="space-y-3">
                            @foreach($product->fragrance_notes as $noteType => $notes)
                                <div class="flex items-start space-x-3">
                                    <span class="text-sm font-semibold text-purple-600 min-w-[100px] capitalize">{{ $noteType }}:</span>
                                    <span class="text-sm text-gray-700 flex-1">{{ is_array($notes) ? implode(', ', $notes) : $notes }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Stock et quantité --}}
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            @if($product->is_in_stock)
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800">
                                    ✅ En stock
                                </span>
                                @if($product->track_stock && $product->is_low_stock)
                                    <p class="text-orange-600 text-sm mt-2">⚠️ Stock limité ({{ $product->stock_quantity }} restants)</p>
                                @endif
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                    ❌ Rupture de stock
                                </span>
                            @endif
                        </div>

                        @if($product->is_in_stock)
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-700 font-medium">Quantité :</span>
                                <div class="flex items-center space-x-3">
                                    <button wire:click="decrementQuantity" 
                                            class="w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span class="w-12 text-center font-bold text-lg">{{ $quantity }}</span>
                                    <button wire:click="incrementQuantity" 
                                            class="w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center transition-colors"
                                            @if($product->track_stock && $quantity >= $product->stock_quantity) disabled @endif>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Actions principales --}}
                    <div class="space-y-4">
                        @if($product->is_in_stock)
                            <button wire:click="addToCart"
                                    class="w-full py-4 px-6 rounded-2xl font-bold text-white text-lg transition-all transform hover:scale-105 shadow-xl hover:shadow-2xl bg-gradient-to-r {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700' : 'from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600' }}">
                                🛒 Ajouter au panier - {{ number_format($product->price * $quantity, 2) }}FCFA
                            </button>
                        @else
                            <button disabled class="w-full bg-gray-300 text-gray-500 py-4 px-6 rounded-2xl font-bold text-lg cursor-not-allowed">
                                Produit indisponible
                            </button>
                        @endif

                        <div class="grid grid-cols-2 gap-4">
                            <button wire:click="toggleWishlist"
                                    class="flex items-center justify-center space-x-2 py-3 px-4 rounded-xl border-2 {{ $isInWishlist ? 'border-red-500 text-red-500 bg-red-50' : 'border-gray-300 text-gray-700 hover:border-red-500 hover:text-red-500' }} transition-all">
                                <svg class="w-5 h-5" fill="{{ $isInWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>{{ $isInWishlist ? 'Favoris ❤️' : 'Favoris' }}</span>
                            </button>

                            <button wire:click="contactWhatsApp"
                                    class="flex items-center justify-center space-x-2 py-3 px-4 rounded-xl bg-green-500 text-white hover:bg-green-600 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106"/>
                                </svg>
                                <span>Contact</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Avis --}}
        @if($product->reviews->count() > 0 || $showReviewForm)
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
                    <span class="w-10 h-10 bg-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100 rounded-full flex items-center justify-center mr-4">
                        <span>⭐</span>
                    </span>
                    Avis clients
                </h2>

                {{-- Formulaire d'avis --}}
                @if($showReviewForm)
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-8 mb-8 border border-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Laisser un avis</h3>
                        
                        <form wire:submit.prevent="submitReview" class="space-y-6">
                            {{-- Note --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Note</label>
                                <div class="flex items-center space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" wire:click="$set('reviewRating', {{ $i }})"
                                                class="text-3xl {{ $i <= $reviewRating ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition-colors">
                                            ⭐
                                        </button>
                                    @endfor
                                    <span class="ml-3 text-gray-600">{{ $reviewRating }}/5</span>
                                </div>
                            </div>

                            {{-- Titre --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'avis</label>
                                <input type="text" wire:model="reviewTitle" 
                                       class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-500 focus:border-transparent outline-none"
                                       placeholder="Résumez votre expérience...">
                                @error('reviewTitle') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Commentaire --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Votre avis</label>
                                <textarea wire:model="reviewComment" rows="4"
                                          class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-500 focus:border-transparent outline-none"
                                          placeholder="Partagez votre expérience avec ce produit..."></textarea>
                                @error('reviewComment') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Boutons --}}
                            <div class="flex items-center space-x-4">
                                <button type="submit" 
                                        class="bg-gradient-to-r {{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700' : 'from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600' }} text-white px-6 py-3 rounded-xl font-semibold transition-all">
                                    Publier l'avis
                                </button>
                                <button type="button" wire:click="$set('showReviewForm', false)"
                                        class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-3 rounded-xl font-semibold transition-all">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Liste des avis --}}
                @if($product->reviews->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($product->reviews->take(6) as $review)
                            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <div class="flex items-center space-x-2 mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="text-lg {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                            @endfor
                                        </div>
                                        <h4 class="font-bold text-gray-900">{{ $review->title }}</h4>
                                        <p class="text-sm text-gray-500">Par {{ $review->user->name }} • {{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                    @if($review->is_verified_purchase)
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Achat vérifié</span>
                                    @endif
                                </div>
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        {{-- Produits connexes --}}
        @if($relatedProducts->count() > 0)
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
                    <span class="w-10 h-10 bg-{{ strpos(strtolower($product->category->name), 'parfum') !== false ? 'purple' : 'pink' }}-100 rounded-full flex items-center justify-center mr-4">
                        <span>{{ strpos(strtolower($product->category->name), 'parfum') !== false ? '🌸' : '💄' }}</span>
                    </span>
                    Produits similaires
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white/70 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group">
                            <div class="relative aspect-square overflow-hidden">
                                @if($relatedProduct->primaryImage)
                                    <img src="{{ Storage::url($relatedProduct->primaryImage->file_path) }}" 
                                         alt="{{ $relatedProduct->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br {{ strpos(strtolower($relatedProduct->category->name), 'parfum') !== false ? 'from-purple-100 to-indigo-100' : 'from-pink-100 to-orange-100' }} flex items-center justify-center">
                                        <span class="text-4xl">{{ strpos(strtolower($relatedProduct->category->name), 'parfum') !== false ? '🌸' : '💄' }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-sm font-medium {{ strpos(strtolower($relatedProduct->category->name), 'parfum') !== false ? 'text-purple-600' : 'text-pink-600' }} mb-1">
                                    {{ $relatedProduct->brand->name }}
                                </p>
                                <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $relatedProduct->name }}</h3>
                                <p class="text-lg font-bold text-gray-900">{{ $relatedProduct->price }}FCFA</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Modal Zoom Image --}}
    @if($showImageZoom)
        <div class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4" 
             wire:click="closeZoom"
             x-data="{ scale: 1, translateX: 0, translateY: 0 }"
             x-on:wheel="scale = Math.max(0.5, Math.min(3, scale + ($event.deltaY > 0 ? -0.1 : 0.1)))"
             x-on:mousemove="if (scale > 1) { translateX = ($event.clientX - window.innerWidth/2) * -0.1; translateY = ($event.clientY - window.innerHeight/2) * -0.1; }">
            
            <div class="relative max-w-5xl max-h-full">
                <button wire:click="closeZoom" 
                        class="absolute top-4 right-4 text-white bg-black/50 hover:bg-black/70 p-2 rounded-full z-10 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <img src="{{ $zoomImageUrl }}" 
                     alt="{{ $product->name }}"
                     class="max-w-full max-h-full object-contain cursor-move transition-transform duration-200"
                     x-bind:style="`transform: scale(${scale}) translate(${translateX}px, ${translateY}px)`"
                     x-on:click.stop="">
                
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/70 text-white px-4 py-2 rounded-full text-sm">
                    Molette pour zoomer • Cliquer pour fermer
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Scripts spéciaux --}}
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('open-whatsapp', (event) => {
            window.open(event.url, '_blank');
        });
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
</style>
@endpush