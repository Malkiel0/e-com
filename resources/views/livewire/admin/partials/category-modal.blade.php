<!-- Category Modal -->
<div x-data="{ 
    showModal: @entangle('showModal'), 
    activeTab: 'general',
    showColorPicker: false,
    showIconPicker: false,
    dragOver: false 
}" 
x-show="showModal"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
class="fixed inset-0 z-50 overflow-y-auto"
style="display: none;">

    <!-- Backdrop -->
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="$wire.closeModal()"
             class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

        <!-- Modal -->
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full sm:p-6">

            <form wire:submit.prevent="saveCategory" class="space-y-6">
                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $isEditing ? 'Modifier la catégorie' : 'Ajouter une nouvelle catégorie' }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $isEditing ? 'Modifiez les informations de votre catégorie' : 'Créez une nouvelle catégorie pour organiser vos produits' }}
                            </p>
                        </div>
                    </div>
                    <button type="button" 
                            @click="$wire.closeModal()"
                            class="rounded-lg p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button type="button" 
                                @click="activeTab = 'general'"
                                :class="activeTab === 'general' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all duration-200">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Informations générales</span>
                            </div>
                        </button>
                        <button type="button" 
                                @click="activeTab = 'appearance'"
                                :class="activeTab === 'appearance' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all duration-200">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h2z"></path>
                                </svg>
                                <span>Apparence & Icônes</span>
                            </div>
                        </button>
                        <button type="button" 
                                @click="activeTab = 'image'"
                                :class="activeTab === 'image' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all duration-200">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Image</span>
                            </div>
                        </button>
                        <button type="button" 
                                @click="activeTab = 'seo'"
                                :class="activeTab === 'seo' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all duration-200">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span>SEO & Métadonnées</span>
                            </div>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="max-h-96 overflow-y-auto">
                    <!-- General Tab -->
                    <div x-show="activeTab === 'general'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         class="space-y-6">
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nom de la catégorie -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <span>Nom de la catégorie *</span>
                                    </span>
                                </label>
                                <input type="text" 
                                       wire:model="name" 
                                       placeholder="Ex: Parfums pour femme"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Catégorie parent -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        </svg>
                                        <span>Catégorie parent</span>
                                    </span>
                                </label>
                                <select wire:model="parent_id" 
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('parent_id') border-red-500 @enderror">
                                    <option value="">Catégorie principale</option>
                                    @foreach($parentCategories as $parent)
                                        @if(!$isEditing || $parent->id !== $selectedCategoryId)
                                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Laissez vide pour créer une catégorie principale</p>
                            </div>

                            <!-- Ordre d'affichage -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h7m6 0h7"></path>
                                        </svg>
                                        <span>Ordre d'affichage</span>
                                    </span>
                                </label>
                                <input type="number" 
                                       wire:model="sort_order" 
                                       min="0"
                                       placeholder="0"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                <p class="mt-1 text-xs text-gray-500">Plus le nombre est petit, plus la catégorie apparaîtra en premier</p>
                            </div>

                            <!-- Description -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                        </svg>
                                        <span>Description</span>
                                    </span>
                                </label>
                                <textarea wire:model="description" 
                                          rows="3" 
                                          placeholder="Description de la catégorie qui apparaîtra sur le site..."
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Appearance Tab -->
                    <div x-show="activeTab === 'appearance'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         class="space-y-6">
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Couleur -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h2z"></path>
                                        </svg>
                                        <span>Couleur de la catégorie *</span>
                                    </span>
                                </label>
                                <div class="space-y-3">
                                    <!-- Color Preview -->
                                    <div class="flex items-center space-x-3">
                                        <div class="w-16 h-16 rounded-lg border-4 border-white shadow-lg flex items-center justify-center text-white font-bold" 
                                             :style="'background-color: ' + $wire.color">
                                            <span x-text="$wire.icon || $wire.name?.substring(0, 2)?.toUpperCase()"></span>
                                        </div>
                                        <div>
                                            <input type="color" 
                                                   wire:model.live="color"
                                                   class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-purple-500">
                                            <p class="text-xs text-gray-500 mt-1">Aperçu en temps réel</p>
                                        </div>
                                        <button type="button" 
                                                wire:click="generateRandomColor"
                                                class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Aléatoire
                                        </button>
                                    </div>

                                    <!-- Color Presets -->
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-2">Couleurs prédéfinies :</p>
                                        <div class="grid grid-cols-5 gap-2">
                                            @php
                                                $presetColors = ['#8B5CF6', '#EF4444', '#10B981', '#F59E0B', '#3B82F6', '#EC4899', '#6366F1', '#84CC16', '#F97316', '#06B6D4'];
                                            @endphp
                                            @foreach($presetColors as $preset)
                                                <button type="button" 
                                                        wire:click="$set('color', '{{ $preset }}')"
                                                        class="w-8 h-8 rounded-lg border-2 {{ $color === $preset ? 'border-gray-800' : 'border-gray-300' }} hover:border-gray-600 transition-colors duration-200" 
                                                        style="background-color: {{ $preset }}">
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @error('color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Icône -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Icône de la catégorie</span>
                                    </span>
                                </label>
                                
                                <!-- Current Icon Display -->
                                <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white text-lg font-bold" 
                                             :style="'background-color: ' + $wire.color">
                                            <span x-text="$wire.icon || ($wire.name?.substring(0, 2)?.toUpperCase() || 'XX')"></span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Aperçu de l'icône</p>
                                            <p class="text-xs text-gray-500">
                                                <span x-show="$wire.icon">Icône sélectionnée : </span>
                                                <span x-show="!$wire.icon">Initiales du nom utilisées</span>
                                                <span x-text="$wire.icon || ($wire.name?.substring(0, 2)?.toUpperCase() || '')"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Icon Selector -->
                                <div class="space-y-3">
                                    <!-- Manual Input -->
                                    <div>
                                        <input type="text" 
                                               wire:model.live="icon" 
                                               placeholder="🌸 Entrez un emoji..."
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                        <p class="mt-1 text-xs text-gray-500">Vous pouvez coller n'importe quel emoji</p>
                                    </div>

                                    <!-- Predefined Icons -->
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-2">Icônes beauté & parfumerie :</p>
                                        <div class="grid grid-cols-8 gap-2">
                                            @foreach($availableIcons as $iconEmoji => $iconName)
                                                <button type="button" 
                                                        wire:click="$set('icon', '{{ $iconEmoji }}')"
                                                        class="p-3 border-2 rounded-lg hover:border-purple-400 transition-colors duration-200 {{ $icon === $iconEmoji ? 'border-purple-500 bg-purple-50' : 'border-gray-200' }}"
                                                        title="{{ $iconName }}">
                                                    <span class="text-2xl">{{ $iconEmoji }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Clear Icon -->
                                    <button type="button" 
                                            wire:click="$set('icon', '')"
                                            class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Supprimer l'icône
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Tab -->
                    <div x-show="activeTab === 'image'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         class="space-y-6">
                        
                        <!-- Existing Image -->
                        @if($existingImage)
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Image actuelle
                                </h4>
                                <div class="relative group max-w-xs">
                                    <img src="{{ Storage::url($existingImage) }}" 
                                         alt="Image de la catégorie"
                                         class="w-full h-48 object-cover rounded-lg border border-gray-300">
                                    <button type="button" 
                                            wire:click="removeExistingImage"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Upload New Image -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ $existingImage ? 'Remplacer l\'image' : 'Ajouter une image' }}
                            </h4>
                            
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-400 transition-colors duration-200"
                                 :class="dragOver ? 'border-purple-400 bg-purple-50' : ''"
                                 @dragover.prevent="dragOver = true"
                                 @dragleave.prevent="dragOver = false"
                                 @drop.prevent="dragOver = false; $refs.fileInput.files = $event.dataTransfer.files; $wire.set('image', $event.dataTransfer.files[0])">
                                
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                
                                <div class="mt-4">
                                    <label for="image" class="cursor-pointer">
                                        <span class="mt-2 block text-sm font-medium text-gray-900">
                                            Glissez votre image ici ou 
                                            <span class="text-purple-600 hover:text-purple-500">cliquez pour parcourir</span>
                                        </span>
                                        <input type="file" 
                                               x-ref="fileInput"
                                               wire:model="image" 
                                               accept="image/*"
                                               id="image" 
                                               class="sr-only">
                                    </label>
                                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF jusqu'à 10MB</p>
                                </div>
                            </div>

                            <!-- Loading State -->
                            <div wire:loading wire:target="image" class="mt-4">
                                <div class="flex items-center justify-center py-4">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">Téléchargement en cours...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Tab -->
                    <div x-show="activeTab === 'seo'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         class="space-y-6">
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Meta Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>Titre SEO</span>
                                    </span>
                                </label>
                                <input type="text" 
                                       wire:model="meta_title" 
                                       placeholder="Titre pour les moteurs de recherche (optionnel)"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                <p class="mt-1 text-xs text-gray-500">Recommandé: 50-60 caractères. Laissez vide pour utiliser le nom de la catégorie.</p>
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                        </svg>
                                        <span>Description SEO</span>
                                    </span>
                                </label>
                                <textarea wire:model="meta_description" 
                                          rows="3" 
                                          placeholder="Description pour les moteurs de recherche (optionnel)"
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 resize-none"></textarea>
                                <p class="mt-1 text-xs text-gray-500">Recommandé: 150-160 caractères. Laissez vide pour utiliser la description de la catégorie.</p>
                            </div>

                            <!-- Meta Keywords -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        <span>Mots-clés SEO</span>
                                    </span>
                                </label>
                                <input type="text" 
                                       wire:model="meta_keywords_text" 
                                       placeholder="parfum, beauté, cosmétique, femme..."
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                <p class="mt-1 text-xs text-gray-500">Séparez chaque mot-clé par une virgule. Optionnel mais recommandé pour le SEO.</p>
                            </div>

                            <!-- Options -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Catégorie active</h4>
                                            <p class="text-sm text-gray-500">La catégorie sera visible sur la boutique</p>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            wire:click="$toggle('is_active')"
                                            :class="$wire.is_active ? 'bg-green-600' : 'bg-gray-200'"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                        <span :class="$wire.is_active ? 'translate-x-5' : 'translate-x-0'"
                                              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-200">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Catégorie vedette</h4>
                                            <p class="text-sm text-gray-500">Mettre en avant sur la page d'accueil</p>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            wire:click="$toggle('is_featured')"
                                            :class="$wire.is_featured ? 'bg-yellow-500' : 'bg-gray-200'"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                        <span :class="$wire.is_featured ? 'translate-x-5' : 'translate-x-0'"
                                              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <button type="button" 
                            @click="$wire.closeModal()"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Annuler
                    </button>

                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-lg transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg wire:loading.remove wire:target="saveCategory" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <svg wire:loading wire:target="saveCategory" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="saveCategory">
                            {{ $isEditing ? 'Mettre à jour' : 'Créer la catégorie' }}
                        </span>
                        <span wire:loading wire:target="saveCategory">
                            Sauvegarde...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>