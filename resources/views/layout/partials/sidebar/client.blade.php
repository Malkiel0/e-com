<!-- Sidebar Client - Navigation E-commerce Intuitive -->
<div class="h-full bg-white shadow-xl overflow-hidden flex flex-col" 
     x-data="{ 
        activeCategory: 'tous',
        priceRange: [0, 200],
        selectedBrands: [],
        inStock: true,
        showFilters: true,
        categories: [
            { 
                id: 'tous', 
                name: 'Tous les produits', 
                icon: '🎀', 
                color: 'indigo',
                count: 156
            },
            { 
                id: 'parfums', 
                name: 'Parfums', 
                icon: '🌸', 
                color: 'purple',
                count: 89,
                subcategories: [
                    { name: 'Eau de Parfum', count: 45 },
                    { name: 'Eau de Toilette', count: 32 },
                    { name: 'Parfums de niche', count: 12 }
                ]
            },
            { 
                id: 'beaute', 
                name: 'Produits de Beauté', 
                icon: '💄', 
                color: 'pink',
                count: 67,
                subcategories: [
                    { name: 'Maquillage', count: 34 },
                    { name: 'Soins visage', count: 22 },
                    { name: 'Soins corps', count: 11 }
                ]
            }
        ],
        brands: [
            { name: 'Chanel', count: 23, popular: true },
            { name: 'Dior', count: 19, popular: true },
            { name: 'YSL', count: 17, popular: true },
            { name: 'Lancôme', count: 15, popular: false },
            { name: 'Hermès', count: 12, popular: false },
            { name: 'Tom Ford', count: 8, popular: false }
        ],
        toggleBrand: function(brand) {
            const index = this.selectedBrands.indexOf(brand);
            if (index > -1) {
                this.selectedBrands.splice(index, 1);
            } else {
                this.selectedBrands.push(brand);
            }
        }
     }">
    
    <!-- En-tête de la sidebar -->
    <div class="p-6 bg-gradient-to-br from-purple-50 to-pink-50 border-b border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-display font-semibold text-gray-900">Découvrir</h2>
            <button @click="showFilters = !showFilters" 
                    class="p-2 rounded-lg hover:bg-white/70 transition-colors">
                <svg class="w-5 h-5 text-gray-600 transform transition-transform" 
                     :class="{ 'rotate-180': !showFilters }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
        
        <!-- Barre de recherche sidebar -->
        <div class="relative">
            <input type="text" 
                   placeholder="Rechercher..." 
                   class="w-full px-4 py-2 pl-10 bg-white rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-sm">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
    
    <!-- Contenu scrollable -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        
        <!-- Navigation par catégories -->
        <div class="p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3 uppercase tracking-wide">Catégories</h3>
            <div class="space-y-2">
                <template x-for="category in categories" :key="category.id">
                    <div>
                        <!-- Catégorie principale -->
                        <button @click="activeCategory = category.id" 
                                class="w-full flex items-center justify-between p-3 rounded-xl transition-all duration-300 group"
                                :class="activeCategory === category.id ? 
                                    (category.color === 'purple' ? 'bg-purple-100 text-purple-700 shadow-lg' : 
                                     category.color === 'pink' ? 'bg-pink-100 text-pink-700 shadow-lg' : 
                                     'bg-indigo-100 text-indigo-700 shadow-lg') : 
                                    'hover:bg-gray-50 text-gray-700'">
                            <div class="flex items-center space-x-3">
                                <span class="text-lg" x-text="category.icon"></span>
                                <div class="text-left">
                                    <div class="font-medium" x-text="category.name"></div>
                                    <div class="text-xs opacity-75" x-text="`${category.count} produits`"></div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-semibold px-2 py-1 rounded-full"
                                      :class="activeCategory === category.id ? 'bg-white/70' : 'bg-gray-200'"
                                      x-text="category.count"></span>
                                <svg x-show="category.subcategories" 
                                     class="w-4 h-4 transform transition-transform"
                                     :class="{ 'rotate-90': activeCategory === category.id }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </button>
                        
                        <!-- Sous-catégories -->
                        <div x-show="activeCategory === category.id && category.subcategories" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="ml-6 mt-2 space-y-1">
                            <template x-for="subcategory in category.subcategories" :key="subcategory.name">
                                <button class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors text-sm text-gray-600">
                                    <span x-text="subcategory.name"></span>
                                    <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full" x-text="subcategory.count"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- Filtres avancés -->
        <div x-show="showFilters" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 max-h-0"
             x-transition:enter-end="opacity-100 max-h-screen"
             class="space-y-6">
            
            <!-- Filtre de prix -->
            <div class="p-4 border-t border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 uppercase tracking-wide flex items-center">
                    <span>💰</span>
                    <span class="ml-2">Prix</span>
                </h3>
                
                <div class="space-y-4">
                    <!-- Range slider stylisé -->
                    <div class="relative">
                        <input type="range" 
                               x-model="priceRange[1]" 
                               min="0" 
                               max="500" 
                               step="10"
                               class="w-full h-2 bg-gradient-to-r from-purple-200 to-pink-200 rounded-lg appearance-none cursor-pointer">
                    </div>
                    
                    <!-- Affichage des valeurs -->
                    <div class="flex items-center justify-between text-sm">
                        <span class="bg-gray-100 px-3 py-1 rounded-lg font-medium">0 FCFA</span>
                        <span class="text-gray-500">à</span>
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg font-medium" x-text="`${priceRange[1]} FCFA`"></span>
                    </div>
                    
                    <!-- Prix rapides -->
                    <div class="grid grid-cols-2 gap-2 mt-3">
                        <button @click="priceRange = [0, 50]" 
                                class="p-2 text-xs bg-gray-100 hover:bg-purple-100 rounded-lg transition-colors">
                            Moins de 50 FCFA
                        </button>
                        <button @click="priceRange = [50, 100]" 
                                class="p-2 text-xs bg-gray-100 hover:bg-purple-100 rounded-lg transition-colors">
                            50 FCFA - 100 FCFA
                        </button>
                        <button @click="priceRange = [100, 200]" 
                                class="p-2 text-xs bg-gray-100 hover:bg-purple-100 rounded-lg transition-colors">
                            100 FCFA - 200 FCFA
                        </button>
                        <button @click="priceRange = [200, 500]" 
                                class="p-2 text-xs bg-gray-100 hover:bg-purple-100 rounded-lg transition-colors">
                            Plus de 200 FCFA
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Filtre par marques -->
            <div class="p-4 border-t border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 uppercase tracking-wide flex items-center">
                    <span>✨</span>
                    <span class="ml-2">Marques</span>
                </h3>
                
                <!-- Marques populaires -->
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-2 font-medium">Marques populaires</p>
                        <template x-for="brand in brands.filter(b => b.popular)" :key="brand.name">
                            <label class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" 
                                           :checked="selectedBrands.includes(brand.name)"
                                           @change="toggleBrand(brand.name)"
                                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <span class="text-sm font-medium text-gray-700" x-text="brand.name"></span>
                                </div>
                                <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full" x-text="brand.count"></span>
                            </label>
                        </template>
                    </div>
                    
                    <!-- Autres marques -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2 font-medium">Autres marques</p>
                        <template x-for="brand in brands.filter(b => !b.popular)" :key="brand.name">
                            <label class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" 
                                           :checked="selectedBrands.includes(brand.name)"
                                           @change="toggleBrand(brand.name)"
                                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <span class="text-sm text-gray-700" x-text="brand.name"></span>
                                </div>
                                <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full" x-text="brand.count"></span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>
            
            <!-- Autres filtres -->
            <div class="p-4 border-t border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 uppercase tracking-wide flex items-center">
                    <span>🎯</span>
                    <span class="ml-2">Options</span>
                </h3>
                
                <div class="space-y-3">
                    <!-- Disponibilité -->
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               x-model="inStock"
                               class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="text-sm text-gray-700">En stock uniquement</span>
                    </label>
                    
                    <!-- Nouveautés -->
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <span class="text-sm text-gray-700">Nouveautés</span>
                    </label>
                    
                    <!-- Promotions -->
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="text-sm text-gray-700">En promotion</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer de la sidebar -->
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        <!-- Boutons d'action -->
        <div class="space-y-2">
            <button class="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white py-2 px-4 rounded-xl font-medium hover:shadow-lg transition-all transform hover:scale-105">
                Appliquer les filtres
            </button>
            <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-xl font-medium transition-colors text-sm">
                Réinitialiser
            </button>
        </div>
        
        <!-- Conseiller virtuel -->
        <div class="mt-4 p-3 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200">
            <div class="flex items-start space-x-2">
                <span class="text-lg">💡</span>
                <div>
                    <p class="text-sm font-medium text-amber-800">Besoin d'aide ?</p>
                    <p class="text-xs text-amber-600 mt-1">Notre conseiller beauté peut vous aider à choisir !</p>
                    <button class="mt-2 text-xs bg-amber-200 hover:bg-amber-300 text-amber-800 px-3 py-1 rounded-full transition-colors">
                        Discuter maintenant
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles personnalisés pour la scrollbar -->
<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #7C3AED 0%, #DB2777 100%);
}
</style>