<div x-data="{ 
    showNotification: false, 
    notificationType: 'success', 
    notificationMessage: '',
    animateIn: false,
    init() {
        this.$nextTick(() => {
            this.animateIn = true;
        });
    }
}" 
x-init="init()"
@notify.window="showNotification = true; notificationType = $event.detail.type; notificationMessage = $event.detail.message; setTimeout(() => showNotification = false, 5000)"
class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-pink-50">

    <!-- Notification Toast -->
    <div x-show="showNotification" 
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-4 right-4 z-50">
        <div :class="notificationType === 'success' ? 'bg-emerald-500' : 'bg-red-500'" 
             class="flex items-center p-4 rounded-lg shadow-lg text-white">
            <svg x-show="notificationType === 'success'" class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <svg x-show="notificationType === 'error'" class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span x-text="notificationMessage"></span>
        </div>
    </div>

    <!-- Header Section -->
    <div :class="animateIn ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-4'" 
         class="transform transition-all duration-700 ease-out bg-white shadow-sm border-b border-gray-100">
        <div class="px-6 py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <!-- Title & Stats -->
                <div class="flex-1">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="p-3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Gestion des Catégories</h1>
                            <p class="text-gray-600 mt-1">Organisez votre catalogue avec une hiérarchie flexible</p>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm">Total</p>
                                    <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-emerald-100 text-sm">Actives</p>
                                    <p class="text-2xl font-bold">{{ $stats['active'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-amber-100 text-sm">Inactives</p>
                                    <p class="text-2xl font-bold">{{ $stats['inactive'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 text-sm">Principales</p>
                                    <p class="text-2xl font-bold">{{ $stats['parent'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-indigo-100 text-sm">Sous-cat.</p>
                                    <p class="text-2xl font-bold">{{ $stats['child'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-pink-100 text-sm">Vedettes</p>
                                    <p class="text-2xl font-bold">{{ $stats['featured'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-pink-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm">Avec produits</p>
                                    <p class="text-2xl font-bold">{{ $stats['with_products'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-gray-500 to-gray-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-100 text-sm">Vides</p>
                                    <p class="text-2xl font-bold">{{ $stats['empty'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 mt-6 lg:mt-0 ml-2">
                    <button wire:click="openModal" 
                            class="group relative inline-flex items-center px-2 py-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Ajouter une catégorie</span>
                    </button>

                    <button wire:click="toggleFilters" 
                            class="group relative inline-flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                        </svg>
                        <span>Filtres</span>
                    </button>

                    <button wire:click="recalculateProductsCounts" 
                            class="group relative inline-flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Recalculer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div x-show="$wire.showFilters" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="bg-white border-b border-gray-200 shadow-sm">
        <div class="px-6 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" 
                           type="text" 
                           placeholder="Rechercher une catégorie..."
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <!-- Status Filter -->
                <div>
                    <select wire:model.live="statusFilter" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500">
                        <option value="all">Tous les statuts</option>
                        <option value="active">Actives</option>
                        <option value="inactive">Inactives</option>
                    </select>
                </div>

                <!-- Parent Filter -->
                <div>
                    <select wire:model.live="parentFilter" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500">
                        <option value="all">Toutes les catégories</option>
                        <option value="parent">Catégories principales</option>
                        <option value="child">Sous-catégories</option>
                    </select>
                </div>

                <!-- View Mode Toggle -->
                <div class="flex bg-gray-100 rounded-lg p-1">
                    <button wire:click="setViewMode('tree')" 
                            class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-200 {{ $viewMode === 'tree' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h7m6 0h7"></path>
                        </svg>
                        Arbre
                    </button>
                    <button wire:click="setViewMode('list')" 
                            class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-200 {{ $viewMode === 'list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        Liste
                    </button>
                </div>

                <!-- Clear Filters -->
                <div class="flex items-end">
                    <button wire:click="clearFilters" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div :class="animateIn ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-4'" 
         class="transform transition-all duration-700 delay-200 ease-out bg-white border-b border-gray-200">
        <div class="px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <!-- Left side: bulk actions -->
                <div class="flex items-center space-x-4">
                    @if(count($bulkSelected) > 0)
                        <div class="flex items-center space-x-3 bg-purple-50 border border-purple-200 rounded-lg px-4 py-2">
                            <span class="text-sm font-medium text-purple-800">{{ count($bulkSelected) }} sélectionné(s)</span>
                            <div class="flex space-x-2">
                                <button wire:click="bulkActivate" 
                                        class="text-emerald-600 hover:text-emerald-800 p-1 rounded transition-colors duration-200" 
                                        title="Activer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                                <button wire:click="bulkDeactivate" 
                                        class="text-amber-600 hover:text-amber-800 p-1 rounded transition-colors duration-200" 
                                        title="Désactiver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                                <button wire:click="bulkDelete" 
                                        class="text-red-600 hover:text-red-800 p-1 rounded transition-colors duration-200" 
                                        title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right side: sorting -->
                <div class="flex items-center space-x-3">
                    <label class="text-sm font-medium text-gray-700">Trier par:</label>
                    <select wire:model.live="sortBy" 
                            class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500">
                        <option value="sort_order">Ordre</option>
                        <option value="name">Nom</option>
                        <option value="created_at">Date de création</option>
                        <option value="products_count">Nombre de produits</option>
                        <option value="updated_at">Dernière modification</option>
                    </select>
                    <button wire:click="sortBy('{{ $sortBy }}')" 
                            class="p-1.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-4 h-4 transform {{ $sortDirection === 'desc' ? 'rotate-180' : '' }} transition-transform duration-200" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Content -->
    <div class="px-6 py-6">
        @if($viewMode === 'tree')
            <!-- Tree View -->
            <div class="space-y-4">
                @forelse($treeCategories as $index => $category)
                    <div :class="animateIn ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" 
                         style="transition-delay: {{ $index * 50 }}ms"
                         class="group bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300">
                        
                        <!-- Parent Category -->
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <!-- Category Info -->
                                <div class="flex items-center space-x-4 flex-1">
                                    <!-- Bulk Selection -->
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" 
                                               wire:model.live="bulkSelected" 
                                               value="{{ $category->id }}"
                                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                    </label>

                                    <!-- Expand/Collapse Button -->
                                    @if($category->children->count() > 0)
                                        <button wire:click="toggleExpanded({{ $category->id }})" 
                                                class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                            <svg class="w-5 h-5 transform transition-transform duration-200 {{ in_array($category->id, $expandedCategories) ? 'rotate-90' : '' }}" 
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    @else
                                        <div class="w-9 h-9"></div>
                                    @endif

                                    <!-- Category Icon & Color -->
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white font-bold" 
                                             style="background-color: {{ $category->color }}">
                                            @if($category->icon)
                                                <span class="text-lg">{{ $category->icon }}</span>
                                            @else
                                                <span class="text-sm">{{ substr($category->name, 0, 2) }}</span>
                                            @endif
                                        </div>

                                        <!-- Category Details -->
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">
                                                {{ $category->name }}
                                            </h3>
                                            @if($category->description)
                                                <p class="text-sm text-gray-600 mt-1 line-clamp-1">{{ $category->description }}</p>
                                            @endif
                                            <div class="flex items-center space-x-4 mt-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $category->products_count }} produit(s)
                                                </span>
                                                @if($category->children->count() > 0)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        {{ $category->children->count() }} sous-catégorie(s)
                                                    </span>
                                                @endif
                                                @if($category->is_featured)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        Vedette
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <!-- Status Toggle -->
                                    <button wire:click="toggleStatus({{ $category->id }})" 
                                            class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                                            title="{{ $category->is_active ? 'Désactiver' : 'Activer' }}">
                                        <div class="w-3 h-3 rounded-full {{ $category->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                                    </button>

                                    <!-- Featured Toggle -->
                                    <button wire:click="toggleFeatured({{ $category->id }})" 
                                            class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                                            title="{{ $category->is_featured ? 'Retirer de la vedette' : 'Mettre en vedette' }}">
                                        <svg class="w-4 h-4 {{ $category->is_featured ? 'text-yellow-500' : 'text-gray-400' }}" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </button>

                                    <!-- Edit -->
                                    <button wire:click="editCategory({{ $category->id }})" 
                                            class="p-2 rounded-lg hover:bg-blue-50 text-blue-600 transition-colors duration-200"
                                            title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <!-- Duplicate -->
                                    <button wire:click="duplicateCategory({{ $category->id }})" 
                                            class="p-2 rounded-lg hover:bg-green-50 text-green-600 transition-colors duration-200"
                                            title="Dupliquer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete -->
                                    <button wire:click="confirmDelete({{ $category->id }})" 
                                            class="p-2 rounded-lg hover:bg-red-50 text-red-600 transition-colors duration-200"
                                            title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Children Categories -->
                        @if($category->children->count() > 0 && in_array($category->id, $expandedCategories))
                            <div class="border-t border-gray-100 bg-gray-50">
                                <div class="p-4 space-y-3">
                                    @foreach($category->children as $child)
                                        <div class="flex items-center justify-between bg-white rounded-lg p-4 shadow-sm">
                                            <!-- Child Category Info -->
                                            <div class="flex items-center space-x-4 flex-1">
                                                <!-- Bulk Selection -->
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" 
                                                           wire:model.live="bulkSelected" 
                                                           value="{{ $child->id }}"
                                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                                </label>

                                                <!-- Indent -->
                                                <div class="w-6 flex justify-center">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </div>

                                                <!-- Child Icon & Details -->
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-sm font-medium" 
                                                         style="background-color: {{ $child->color }}">
                                                        @if($child->icon)
                                                            <span>{{ $child->icon }}</span>
                                                        @else
                                                            <span>{{ substr($child->name, 0, 2) }}</span>
                                                        @endif
                                                    </div>

                                                    <div>
                                                        <h4 class="font-medium text-gray-900">{{ $child->name }}</h4>
                                                        <div class="flex items-center space-x-2 mt-1">
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $child->products_count }} produit(s)
                                                            </span>
                                                            @if($child->is_featured)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                                    </svg>
                                                                    Vedette
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Child Actions -->
                                            <div class="flex items-center space-x-1">
                                                <!-- Status -->
                                                <button wire:click="toggleStatus({{ $child->id }})" 
                                                        class="p-1.5 rounded hover:bg-gray-100 transition-colors duration-200">
                                                    <div class="w-3 h-3 rounded-full {{ $child->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                                                </button>

                                                <!-- Featured -->
                                                <button wire:click="toggleFeatured({{ $child->id }})" 
                                                        class="p-1.5 rounded hover:bg-gray-100 transition-colors duration-200">
                                                    <svg class="w-3.5 h-3.5 {{ $child->is_featured ? 'text-yellow-500' : 'text-gray-400' }}" 
                                                         fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                </button>

                                                <!-- Edit -->
                                                <button wire:click="editCategory({{ $child->id }})" 
                                                        class="p-1.5 rounded hover:bg-blue-50 text-blue-600 transition-colors duration-200">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>

                                                <!-- Delete -->
                                                <button wire:click="confirmDelete({{ $child->id }})" 
                                                        class="p-1.5 rounded hover:bg-red-50 text-red-600 transition-colors duration-200">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune catégorie trouvée</h3>
                        <p class="text-gray-500 text-center mb-4">Il n'y a pas de catégories correspondant à vos critères de recherche.</p>
                        <button wire:click="clearFilters" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                            Réinitialiser les filtres
                        </button>
                    </div>
                @endforelse
            </div>
        @else
            <!-- List View -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" wire:model.live="selectAll" wire:click="toggleSelectAll" 
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hiérarchie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produits</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" wire:model.live="bulkSelected" value="{{ $category->id }}"
                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-lg flex items-center justify-center text-white font-medium" 
                                             style="background-color: {{ $category->color }}">
                                            @if($category->icon)
                                                <span class="text-lg">{{ $category->icon }}</span>
                                            @else
                                                <span class="text-sm">{{ substr($category->name, 0, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                            @if($category->description)
                                                <div class="text-sm text-gray-500 line-clamp-1">{{ $category->description }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($category->parent)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Sous-catégorie de {{ $category->parent->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Catégorie principale
                                        </span>
                                    @endif
                                    @if($category->children_count > 0)
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $category->children_count }} enfant(s)
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $category->products_count }}</div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $category->sort_order }}</div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="toggleStatus({{ $category->id }})" 
                                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 {{ $category->is_active ? 'bg-green-600' : 'bg-gray-200' }}">
                                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $category->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                        </button>
                                        @if($category->is_featured)
                                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="editCategory({{ $category->id }})" 
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="duplicateCategory({{ $category->id }})" 
                                                class="text-green-600 hover:text-green-900 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $category->id }})" 
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune catégorie</h3>
                                    <p class="mt-1 text-sm text-gray-500">Commencez par créer une nouvelle catégorie.</p>
                                    <div class="mt-6">
                                        <button wire:click="openModal" 
                                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Nouvelle catégorie
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="mt-8">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Category Modal -->
    @if($showModal)
        @include('livewire.admin.partials.category-modal')
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        @include('livewire.admin.partials.category-delete-modal')
    @endif
</div>