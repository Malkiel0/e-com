<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class Categories extends Component
{
    use WithPagination, WithFileUploads;

    // Propriétés de filtrage et recherche
    public $search = '';
    public $statusFilter = 'all'; // all, active, inactive
    public $parentFilter = 'all'; // all, parent, child
    public $sortBy = 'sort_order';
    public $sortDirection = 'asc';
    public $viewMode = 'tree'; // tree, list

    // Propriétés de modal et édition
    public $showModal = false;
    public $showDeleteModal = false;
    public $isEditing = false;
    public $selectedCategoryId = null;

    // Propriétés du formulaire catégorie
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('nullable|string')]
    public $description = '';
    
    #[Validate('nullable|exists:categories,id')]
    public $parent_id = '';
    
    #[Validate('required|string|max:7')]
    public $color = '#8B5CF6';
    
    #[Validate('nullable|string|max:10')]
    public $icon = '';
    
    #[Validate('nullable|integer|min:0')]
    public $sort_order = 0;
    
    public $is_active = true;
    public $is_featured = false;
    
    #[Validate('nullable|string|max:255')]
    public $meta_title = '';
    
    #[Validate('nullable|string')]
    public $meta_description = '';
    
    #[Validate('nullable|array')]
    public $meta_keywords = [];
    
    public $meta_keywords_text = '';
    
    // Image/Icône
    public $image;
    public $existingImage = null;
    
    // Propriétés d'interface
    public $bulkSelected = [];
    public $selectAll = false;
    public $showFilters = false;
    public $expandedCategories = []; // Pour l'affichage en arbre
    
    // Réorganisation
    public $draggedCategory = null;
    public $sortableCategories = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'parentFilter' => ['except' => 'all'],
        'sortBy' => ['except' => 'sort_order'],
        'sortDirection' => ['except' => 'asc'],
        'viewMode' => ['except' => 'tree']
    ];

    // Liste d'icônes disponibles
    public $availableIcons = [
        '🌸' => 'Fleur rose',
        '💄' => 'Rouge à lèvres',
        '💅' => 'Vernis à ongles',
        '👄' => 'Lèvres',
        '🌹' => 'Rose',
        '✨' => 'Brillant',
        '💎' => 'Diamant',
        '🧴' => 'Flacon',
        '🌿' => 'Feuille',
        '🦋' => 'Papillon',
        '💫' => 'Étoiles',
        '🌺' => 'Hibiscus',
        '🎀' => 'Nœud',
        '👑' => 'Couronne',
        '🔮' => 'Boule magique'
    ];

    public function mount()
    {
        $this->resetPage();
        $this->loadExpandedCategories();
    }

    

    public function getCategories()
    {
        $query = Category::withCount(['products', 'children']);

        // Filtrage par type
        if ($this->parentFilter === 'parent') {
            $query->whereNull('parent_id');
        } elseif ($this->parentFilter === 'child') {
            $query->whereNotNull('parent_id');
        }

        // Recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filtres
        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        // Tri
        if ($this->sortBy === 'products_count') {
            $query->orderBy('products_count', $this->sortDirection);
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query->paginate(15);
    }

    public function getTreeCategories()
    {
        return Category::with(['children' => function($query) {
            $query->orderBy('sort_order');
        }])
        ->whereNull('parent_id')
        ->orderBy('sort_order')
        ->get();
    }

    public function getCategoryStats()
    {
        return [
            'total' => Category::count(),
            'active' => Category::where('is_active', true)->count(),
            'inactive' => Category::where('is_active', false)->count(),
            'parent' => Category::whereNull('parent_id')->count(),
            'child' => Category::whereNotNull('parent_id')->count(),
            'featured' => Category::where('is_featured', true)->count(),
            'with_products' => Category::has('products')->count(),
            'empty' => Category::doesntHave('products')->count(),
        ];
    }

    // Actions sur les filtres
    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function clearFilters()
    {
        $this->reset(['search', 'statusFilter', 'parentFilter']);
        $this->resetPage();
    }

    // Gestion du mode d'affichage
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
        if ($mode === 'tree') {
            $this->loadExpandedCategories();
        }
    }

    // Gestion de l'arbre (expand/collapse)
    public function toggleExpanded($categoryId)
    {
        if (in_array($categoryId, $this->expandedCategories)) {
            $this->expandedCategories = array_diff($this->expandedCategories, [$categoryId]);
        } else {
            $this->expandedCategories[] = $categoryId;
        }
        session(['expanded_categories' => $this->expandedCategories]);
    }

    public function loadExpandedCategories()
    {
        $this->expandedCategories = session('expanded_categories', []);
    }

    // Actions de tri
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // Gestion de la modal
    public function openModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function editCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        
        $this->selectedCategoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->parent_id = $category->parent_id;
        $this->color = $category->color;
        $this->icon = $category->icon;
        $this->sort_order = $category->sort_order;
        $this->is_active = $category->is_active;
        $this->is_featured = $category->is_featured;
        $this->meta_title = $category->meta_data['title'] ?? '';
        $this->meta_description = $category->meta_data['description'] ?? '';
        $this->meta_keywords_text = is_array($category->meta_data['keywords'] ?? []) ? 
            implode(', ', $category->meta_data['keywords']) : '';
        $this->existingImage = $category->image;
        
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'description', 'parent_id', 'color', 'icon', 'sort_order',
            'is_active', 'is_featured', 'meta_title', 'meta_description',
            'meta_keywords_text', 'image', 'existingImage', 'selectedCategoryId'
        ]);
        $this->color = '#8B5CF6';
        $this->is_active = true;
        $this->is_featured = false;
        $this->sort_order = 0;
    }

    // Sauvegarde de la catégorie
    public function saveCategory()
    {
        $this->validate();

        try {
            // Préparation des métadonnées
            $metaData = [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
                'keywords' => $this->meta_keywords_text ? explode(', ', $this->meta_keywords_text) : []
            ];

            // Gestion de l'image
            $imagePath = $this->existingImage;
            if ($this->image) {
                // Supprimer l'ancienne image si elle existe
                if ($this->existingImage) {
                    Storage::disk('public')->delete($this->existingImage);
                }
                $imagePath = $this->image->store('categories', 'public');
            }

            $data = [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'parent_id' => $this->parent_id ?: null,
                'color' => $this->color,
                'icon' => $this->icon,
                'image' => $imagePath,
                'sort_order' => $this->sort_order,
                'is_active' => $this->is_active,
                'is_featured' => $this->is_featured,
                'meta_data' => $metaData,
            ];

            if ($this->isEditing) {
                $category = Category::findOrFail($this->selectedCategoryId);
                $category->update($data);
                $message = 'Catégorie mise à jour avec succès !';
            } else {
                // Définir l'ordre automatiquement si non spécifié
                if ($this->sort_order === 0) {
                    $maxOrder = Category::where('parent_id', $this->parent_id ?: null)->max('sort_order') ?? 0;
                    $data['sort_order'] = $maxOrder + 1;
                }
                
                Category::create($data);
                $message = 'Catégorie créée avec succès !';
            }

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => $message
            ]);

            $this->closeModal();
            $this->resetPage();

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la sauvegarde : ' . $e->getMessage()
            ]);
        }
    }

    // Suppression de catégorie
    public function confirmDelete($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
        $this->showDeleteModal = true;
    }

    public function deleteCategory()
    {
        try {
            $category = Category::findOrFail($this->selectedCategoryId);
            
            // Vérifier s'il y a des produits ou des sous-catégories
            if ($category->products()->count() > 0) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Impossible de supprimer une catégorie qui contient des produits.'
                ]);
                return;
            }

            if ($category->children()->count() > 0) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Impossible de supprimer une catégorie qui contient des sous-catégories.'
                ]);
                return;
            }
            
            // Supprimer l'image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            $category->delete();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Catégorie supprimée avec succès !'
            ]);

            $this->showDeleteModal = false;
            $this->resetPage();

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ]);
        }
    }

    // Actions en lot
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->bulkSelected = $this->getCategories()->pluck('id')->toArray();
        } else {
            $this->bulkSelected = [];
        }
    }

    public function bulkActivate()
    {
        Category::whereIn('id', $this->bulkSelected)->update(['is_active' => true]);
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => count($this->bulkSelected) . ' catégories activées !'
        ]);
        $this->bulkSelected = [];
        $this->selectAll = false;
    }

    public function bulkDeactivate()
    {
        Category::whereIn('id', $this->bulkSelected)->update(['is_active' => false]);
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => count($this->bulkSelected) . ' catégories désactivées !'
        ]);
        $this->bulkSelected = [];
        $this->selectAll = false;
    }

    public function bulkDelete()
    {
        $categories = Category::whereIn('id', $this->bulkSelected)->with(['products', 'children'])->get();
        
        foreach ($categories as $category) {
            if ($category->products()->count() > 0 || $category->children()->count() > 0) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Certaines catégories contiennent des produits ou sous-catégories et ne peuvent être supprimées.'
                ]);
                return;
            }
        }

        foreach ($categories as $category) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->delete();
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => count($this->bulkSelected) . ' catégories supprimées !'
        ]);
        
        $this->bulkSelected = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    // Dupliquer une catégorie
    public function duplicateCategory($categoryId)
    {
        try {
            $originalCategory = Category::findOrFail($categoryId);
            
            $newCategory = $originalCategory->replicate();
            $newCategory->name = $originalCategory->name . ' (Copie)';
            $newCategory->slug = Str::slug($newCategory->name);
            $newCategory->is_active = false;
            $newCategory->sort_order = $originalCategory->sort_order + 1;
            $newCategory->save();

            // Dupliquer l'image si elle existe
            if ($originalCategory->image) {
                $newPath = 'categories/' . basename($originalCategory->image);
                Storage::disk('public')->copy($originalCategory->image, $newPath);
                $newCategory->update(['image' => $newPath]);
            }

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Catégorie dupliquée avec succès !'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la duplication : ' . $e->getMessage()
            ]);
        }
    }

    // Toggle statut actif
    public function toggleStatus($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->update(['is_active' => !$category->is_active]);
        
        $status = $category->is_active ? 'activée' : 'désactivée';
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Catégorie {$status} !"
        ]);
    }

    // Toggle featured
    public function toggleFeatured($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->update(['is_featured' => !$category->is_featured]);
        
        $status = $category->is_featured ? 'mise en avant' : 'retirée de la mise en avant';
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Catégorie {$status} !"
        ]);
    }

    // Réorganisation par drag & drop
    public function updateSortOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Category::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Ordre des catégories mis à jour !'
        ]);
    }

    // Déplacer une catégorie vers un parent différent
    public function moveCategory($categoryId, $newParentId = null)
    {
        $category = Category::findOrFail($categoryId);
        
        // Éviter les boucles infinies
        if ($newParentId && $this->wouldCreateLoop($categoryId, $newParentId)) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Cette action créerait une boucle dans la hiérarchie !'
            ]);
            return;
        }

        $category->update(['parent_id' => $newParentId]);
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Catégorie déplacée avec succès !'
        ]);
    }

    // Vérifier si le déplacement créerait une boucle
    private function wouldCreateLoop($categoryId, $newParentId)
    {
        $parent = Category::find($newParentId);
        
        while ($parent) {
            if ($parent->id == $categoryId) {
                return true;
            }
            $parent = $parent->parent;
        }
        
        return false;
    }

    // Supprimer l'image existante
    public function removeExistingImage()
    {
        if ($this->existingImage) {
            Storage::disk('public')->delete($this->existingImage);
            $this->existingImage = null;
        }
    }

    // Mise à jour en temps réel des filtres
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedParentFilter()
    {
        $this->resetPage();
    }

    // Recalculer le nombre de produits pour toutes les catégories
    public function recalculateProductsCounts()
    {
        $categories = Category::all();
        
        foreach ($categories as $category) {
            $count = $category->products()->count();
            $category->update(['products_count' => $count]);
        }
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Compteurs de produits recalculés !'
        ]);
    }

    // Générer des couleurs automatiques pour les catégories
    public function generateRandomColor()
    {
        $colors = [
            '#8B5CF6', '#EF4444', '#10B981', '#F59E0B', '#3B82F6',
            '#EC4899', '#6366F1', '#84CC16', '#F97316', '#06B6D4'
        ];
        
        $this->color = $colors[array_rand($colors)];
    }

    public function render()
    {
        $categories = $this->getCategories();
        $parentCategories = Category::whereNull('parent_id')->active()->orderBy('sort_order')->get();
        $stats = $this->getCategoryStats();
        $treeCategories = $this->getTreeCategories();

        return view('livewire.admin.categories', [
            'categories' => $categories,
            'parentCategories' => $parentCategories,
            'stats' => $stats,
            'treeCategories' => $treeCategories,
            'availableIcons' => $this->availableIcons
        ])->layout('layout.admin');
    }
}