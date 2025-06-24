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
class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50 to-teal-50">

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
                        <div class="p-3 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a2.5 2.5 0 005 0 2.5 2.5 0 00-5 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Gestion des Promotions</h1>
                            <p class="text-gray-600 mt-1">Créez et gérez vos codes promo et réductions</p>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
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

                        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-yellow-100 text-sm">Programmées</p>
                                    <p class="text-2xl font-bold">{{ $stats['scheduled'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-red-100 text-sm">Expirées</p>
                                    <p class="text-2xl font-bold">{{ $stats['expired'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 text-sm">Utilisées</p>
                                    <p class="text-2xl font-bold">{{ $stats['used_this_month'] }}</p>
                                </div>
                                <svg class="w-8 h-8 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm">Économies</p>
                                    <p class="text-2xl font-bold">{{ number_format($stats['total_savings'], 0) }}€</p>
                                </div>
                                <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-indigo-100 text-sm">Plus utilisée</p>
                                    <p class="text-lg font-bold truncate">{{ Str::limit($stats['most_used'], 8) }}</p>
                                </div>
                                <svg class="w-8 h-8 text-indigo-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg p-4 text-white transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-pink-100 text-sm">Impact CA</p>
                                    <p class="text-xl font-bold">{{ $stats['revenue_impact'] >= 0 ? '+' : '' }}{{ number_format($stats['revenue_impact'], 0) }}€</p>
                                </div>
                                <svg class="w-8 h-8 text-pink-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 mt-6 lg:mt-0 ml-2">
                    <button wire:click="openModal" 
                            class="group relative inline-flex items-center px-2 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Créer une promotion</span>
                    </button>

                    <button wire:click="toggleFilters" 
                            class="group relative inline-flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                        </svg>
                        <span>Filtres</span>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                <!-- Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" 
                           type="text" 
                           placeholder="Rechercher une promotion..."
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Type Filter -->
                <div>
                    <select wire:model.live="typeFilter" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="all">Tous les types</option>
                        @foreach($promotionTypes as $key => $type)
                            <option value="{{ $key }}">{{ $type['icon'] }} {{ $type['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <select wire:model.live="statusFilter" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="all">Tous les statuts</option>
                        <option value="active">🟢 Actives</option>
                        <option value="scheduled">⏰ Programmées</option>
                        <option value="expired">🔴 Expirées</option>
                        <option value="inactive">⚫ Inactives</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <select wire:model.live="dateFilter" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="all">Toutes les dates</option>
                        <option value="current">📅 En cours</option>
                        <option value="upcoming">🔜 À venir</option>
                        <option value="expired">❌ Expirées</option>
                    </select>
                </div>

                <!-- Usage Filter -->
                <div>
                    <select wire:model.live="usageFilter" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="all">Toute utilisation</option>
                        <option value="unused">🆕 Non utilisées</option>
                        <option value="partially_used">📊 Partiellement utilisées</option>
                        <option value="fully_used">✅ Complètement utilisées</option>
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="flex items-end">
                    <button wire:click="clearFilters" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
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
                <!-- Left side: bulk actions and view mode -->
                <div class="flex items-center space-x-4">
                    @if(count($bulkSelected) > 0)
                        <div class="flex items-center space-x-3 bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-2">
                            <span class="text-sm font-medium text-emerald-800">{{ count($bulkSelected) }} sélectionné(s)</span>
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

                    <!-- View Mode Toggle -->
                    <div class="flex bg-gray-100 rounded-lg p-1">
                        <button wire:click="setViewMode('card')" 
                                class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-200 {{ $viewMode === 'card' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Cartes
                        </button>
                        <button wire:click="setViewMode('table')" 
                                class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-200 {{ $viewMode === 'table' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Tableau
                        </button>
                    </div>
                </div>

                <!-- Right side: sorting -->
                <div class="flex items-center space-x-3">
                    <label class="text-sm font-medium text-gray-700">Trier par:</label>
                    <select wire:model.live="sortBy" 
                            class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="created_at">Date de création</option>
                        <option value="name">Nom</option>
                        <option value="starts_at">Date de début</option>
                        <option value="ends_at">Date de fin</option>
                        <option value="usage_count">Utilisation</option>
                        <option value="priority">Priorité</option>
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

    <!-- Promotions Content -->
    <div class="px-6 py-6">
        @if($viewMode === 'card')
            <!-- Card View -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($promotions as $index => $promotion)
                    <div :class="animateIn ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" 
                         style="transition-delay: {{ $index * 50 }}ms"
                         class="group relative bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                        
                        <!-- Promotion Header -->
                        <div class="relative p-6 bg-gradient-to-r from-{{ $promotion->is_active ? 'emerald' : 'gray' }}-500 to-{{ $promotion->is_active ? 'teal' : 'gray' }}-600">
                            <!-- Type Icon -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <span class="text-2xl">{{ $promotionTypes[$promotion->type]['icon'] ?? '🎯' }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-white">{{ $promotion->name }}</h3>
                                        <p class="text-sm text-white text-opacity-80">{{ $promotionTypes[$promotion->type]['name'] ?? 'Promotion' }}</p>
                                    </div>
                                </div>
                                
                                <!-- Bulk Selection -->
                                <label class="inline-flex items-center">
                                    <input type="checkbox" 
                                           wire:model.live="bulkSelected" 
                                           value="{{ $promotion->id }}"
                                           class="rounded border-white text-emerald-600 bg-white bg-opacity-20 focus:ring-white focus:ring-opacity-50">
                                </label>
                            </div>

                            <!-- Promotion Value -->
                            <div class="text-center">
                                <div class="text-3xl font-bold text-white">
                                    @if($promotion->type === 'percentage')
                                        {{ $promotion->value }}%
                                    @elseif($promotion->type === 'fixed_amount')
                                        {{ $promotion->value }}€
                                    @elseif($promotion->type === 'free_shipping')
                                        GRATUIT
                                    @else
                                        {{ $promotion->value }}
                                    @endif
                                </div>
                                <p class="text-sm text-white text-opacity-80 mt-1">
                                    {{ $promotionTypes[$promotion->type]['example'] ?? 'Promotion spéciale' }}
                                </p>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-4 right-4">
                                @php
                                    $now = now();
                                    $isActive = $promotion->is_active && $promotion->starts_at <= $now && (!$promotion->ends_at || $promotion->ends_at > $now);
                                    $isScheduled = $promotion->is_active && $promotion->starts_at > $now;
                                    $isExpired = $promotion->ends_at && $promotion->ends_at < $now;
                                @endphp
                                
                                @if($isActive)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        🟢 Active
                                    </span>
                                @elseif($isScheduled)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        ⏰ Programmée
                                    </span>
                                @elseif($isExpired)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        ❌ Expirée
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        ⚫ Inactive
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Promotion Info -->
                        <div class="p-6">
                            <!-- Description -->
                            @if($promotion->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $promotion->description }}</p>
                            @endif

                            <!-- Codes -->
                            @if($promotion->codes_count > 0)
                                <div class="mb-4">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        <span class="text-sm text-gray-600">{{ $promotion->codes_count }} code(s) promo</span>
                                    </div>
                                    @if($promotion->codes->first())
                                        <div class="mt-2 inline-flex items-center px-3 py-1 rounded-md text-sm font-mono bg-gray-100 text-gray-800">
                                            {{ $promotion->codes->first()->code }}
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Dates -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Début: {{ $promotion->starts_at?->format('d/m/Y H:i') ?? 'Non défini' }}</span>
                                </div>
                                @if($promotion->ends_at)
                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Fin: {{ $promotion->ends_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Usage Stats -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">
                                        {{ $promotion->usages_count ?? 0 }} utilisation(s)
                                        @if($promotion->usage_limit)
                                            / {{ $promotion->usage_limit }}
                                        @endif
                                    </span>
                                </div>
                                
                                @if($promotion->minimum_amount)
                                    <span class="text-xs text-gray-500">Min: {{ $promotion->minimum_amount }}€</span>
                                @endif
                            </div>

                            <!-- Progress Bar -->
                            @if($promotion->usage_limit)
                                <div class="mb-4">
                                    @php
                                        $progress = ($promotion->usages_count / $promotion->usage_limit) * 100;
                                    @endphp
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full transition-all duration-300" 
                                             style="width: {{ min($progress, 100) }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ round($progress, 1) }}% utilisé</p>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <!-- Status Toggle -->
                                    <button wire:click="toggleStatus({{ $promotion->id }})" 
                                            class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                                            title="{{ $promotion->is_active ? 'Désactiver' : 'Activer' }}">
                                        <div class="w-3 h-3 rounded-full {{ $promotion->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                                    </button>

                                    <!-- Preview -->
                                    <button wire:click="previewPromotion({{ $promotion->id }})" 
                                            class="p-2 rounded-lg hover:bg-blue-50 text-blue-600 transition-colors duration-200"
                                            title="Aperçu">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <!-- Edit -->
                                    <button wire:click="editPromotion({{ $promotion->id }})" 
                                            class="p-2 rounded-lg hover:bg-blue-50 text-blue-600 transition-colors duration-200"
                                            title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <!-- Duplicate -->
                                    <button wire:click="duplicatePromotion({{ $promotion->id }})" 
                                            class="p-2 rounded-lg hover:bg-green-50 text-green-600 transition-colors duration-200"
                                            title="Dupliquer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete -->
                                    <button wire:click="confirmDelete({{ $promotion->id }})" 
                                            class="p-2 rounded-lg hover:bg-red-50 text-red-600 transition-colors duration-200"
                                            title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune promotion trouvée</h3>
                        <p class="text-gray-500 text-center mb-4">Il n'y a pas de promotions correspondant à vos critères de recherche.</p>
                        <button wire:click="clearFilters" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                            Réinitialiser les filtres
                        </button>
                    </div>
                @endforelse
            </div>
        @else
            <!-- Table View -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" wire:model.live="selectAll" wire:click="toggleSelectAll" 
                                       class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promotion</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type & Valeur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($promotions as $promotion)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" wire:model.live="bulkSelected" value="{{ $promotion->id }}"
                                           class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-lg flex items-center justify-center bg-emerald-100">
                                            <span class="text-lg">{{ $promotionTypes[$promotion->type]['icon'] ?? '🎯' }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $promotion->name }}</div>
                                            @if($promotion->description)
                                                <div class="text-sm text-gray-500 line-clamp-1">{{ Str::limit($promotion->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $promotionTypes[$promotion->type]['name'] ?? 'Promotion' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @if($promotion->type === 'percentage')
                                            {{ $promotion->value }}% de réduction
                                        @elseif($promotion->type === 'fixed_amount')
                                            {{ $promotion->value }}€ de réduction
                                        @elseif($promotion->type === 'free_shipping')
                                            Livraison gratuite
                                        @else
                                            {{ $promotion->value }}
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>Début: {{ $promotion->starts_at?->format('d/m/Y') ?? 'Non défini' }}</div>
                                    @if($promotion->ends_at)
                                        <div>Fin: {{ $promotion->ends_at->format('d/m/Y') }}</div>
                                    @else
                                        <div class="text-emerald-600">Sans fin</div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $promotion->usages_count ?? 0 }}
                                        @if($promotion->usage_limit)
                                            / {{ $promotion->usage_limit }}
                                        @endif
                                    </div>
                                    @if($promotion->usage_limit)
                                        @php
                                            $progress = ($promotion->usages_count / $promotion->usage_limit) * 100;
                                        @endphp
                                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ min($progress, 100) }}%"></div>
                                        </div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $now = now();
                                        $isActive = $promotion->is_active && $promotion->starts_at <= $now && (!$promotion->ends_at || $promotion->ends_at > $now);
                                        $isScheduled = $promotion->is_active && $promotion->starts_at > $now;
                                        $isExpired = $promotion->ends_at && $promotion->ends_at < $now;
                                    @endphp
                                    
                                    @if($isActive)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            🟢 Active
                                        </span>
                                    @elseif($isScheduled)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            ⏰ Programmée
                                        </span>
                                    @elseif($isExpired)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            ❌ Expirée
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            ⚫ Inactive
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="toggleStatus({{ $promotion->id }})" 
                                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 {{ $promotion->is_active ? 'bg-emerald-600' : 'bg-gray-200' }}">
                                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $promotion->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                        </button>
                                        
                                        <button wire:click="editPromotion({{ $promotion->id }})" 
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        
                                        <button wire:click="duplicatePromotion({{ $promotion->id }})" 
                                                class="text-green-600 hover:text-green-900 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                        
                                        <button wire:click="confirmDelete({{ $promotion->id }})" 
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune promotion</h3>
                                    <p class="mt-1 text-sm text-gray-500">Commencez par créer une nouvelle promotion.</p>
                                    <div class="mt-6">
                                        <button wire:click="openModal" 
                                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Nouvelle promotion
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
        @if($promotions->hasPages())
            <div class="mt-8">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>

    <!-- Promotion Modal -->
    @if($showModal)
        @include('livewire.admin.partials.promotion-modal')
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        @include('livewire.admin.partials.promotion-delete-modal')
    @endif

    <!-- Preview Modal -->
    @if($showPreviewModal)
        @include('livewire.admin.partials.promotion-preview-modal')
    @endif
</div>