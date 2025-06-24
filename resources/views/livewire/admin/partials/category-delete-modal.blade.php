<!-- Category Delete Confirmation Modal -->
<div x-data="{ showDeleteModal: @entangle('showDeleteModal') }" 
     x-show="showDeleteModal"
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
        <div x-show="showDeleteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="$wire.set('showDeleteModal', false)"
             class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

        <!-- Modal -->
        <div x-show="showDeleteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white rounded-2xl px-6 pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">

            <div class="sm:flex sm:items-start">
                <!-- Warning Icon -->
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-red-100 sm:mx-0 sm:h-12 sm:w-12">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>

                <!-- Content -->
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Supprimer la catégorie
                    </h3>
                    
                    <div class="mt-2 space-y-4">
                        <p class="text-sm text-gray-500">
                            Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.
                        </p>

                        <!-- Warning Boxes -->
                        <div class="space-y-3">
                            <!-- Products Warning -->
                            <div class="p-4 bg-amber-50 rounded-lg border border-amber-200">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-amber-800 mb-1">Produits associés</h4>
                                        <p class="text-sm text-amber-700">
                                            ⚠️ Une catégorie contenant des produits ne peut pas être supprimée. 
                                            Vous devez d'abord déplacer ou supprimer tous les produits de cette catégorie.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Subcategories Warning -->
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-blue-800 mb-1">Sous-catégories</h4>
                                        <p class="text-sm text-blue-700">
                                            🔄 Une catégorie parent contenant des sous-catégories ne peut pas être supprimée. 
                                            Supprimez d'abord toutes les sous-catégories.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Warning -->
                            <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-purple-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-purple-800 mb-1">Images et fichiers</h4>
                                        <p class="text-sm text-purple-700">
                                            🗂️ L'image associée à cette catégorie sera également supprimée définitivement.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Critical Warning -->
                            <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-red-800 mb-1">⚠️ Action irréversible</h4>
                                        <p class="text-sm text-red-700 font-medium">
                                            Cette action ne peut pas être annulée. La catégorie sera définitivement supprimée.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirmation Text -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-700 text-center">
                                <span class="font-medium">Vérification :</span>
                                Seules les catégories vides (sans produits ni sous-catégories) peuvent être supprimées.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 sm:mt-4 sm:flex sm:flex-row-reverse space-y-3 sm:space-y-0 sm:space-x-3 sm:space-x-reverse">
                <button wire:click="deleteCategory" 
                        wire:loading.attr="disabled"
                        class="group relative w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    
                    <!-- Normal State -->
                    <div wire:loading.remove wire:target="deleteCategory" class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Supprimer définitivement</span>
                    </div>
                    
                    <!-- Loading State -->
                    <div wire:loading wire:target="deleteCategory" class="flex items-center">
                        <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Suppression...</span>
                    </div>
                </button>

                <button @click="$wire.set('showDeleteModal', false)" 
                        type="button"
                        class="group relative w-full inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:w-auto transform hover:scale-105 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Annuler
                </button>
            </div>

            <!-- Additional Info -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center justify-center space-x-2 text-xs text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Conseil : Désactivez plutôt que supprimer pour conserver l'historique</span>
                </div>
            </div>
        </div>
    </div>
</div>