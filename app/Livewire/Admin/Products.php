<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class Products extends Component
{
    use WithPagination, WithFileUploads;

    // Propriétés de filtrage et recherche
    public $search = '';
    public $activeTab = 'all'; // all, parfums, beaute
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $statusFilter = 'all'; // all, active, inactive
    public $brandFilter = '';
    public $categoryFilter = '';
    public $priceMin = '';
    public $priceMax = '';
    public $stockFilter = 'all'; // all, in_stock, low_stock, out_of_stock

    // Propriétés de modal et édition
    public $showModal = false;
    public $showDeleteModal = false;
    public $isEditing = false;
    public $selectedProductId = null;

    // Propriétés du formulaire produit
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('required|string')]
    public $description = '';
    
    #[Validate('nullable|string')]
    public $short_description = '';
    
    #[Validate('required|numeric|min:0')]
    public $price = '';
    
    #[Validate('nullable|numeric|min:0')]
    public $compare_price = '';
    
    #[Validate('required|exists:categories,id')]
    public $category_id = '';
    
    #[Validate('required|exists:brands,id')]
    public $brand_id = '';
    
    #[Validate('required|integer|min:0')]
    public $stock_quantity = '';
    
    #[Validate('nullable|string|max:50')]
    public $sku = '';
    
    #[Validate('nullable|string|max:50')]
    public $volume = '';
    
    #[Validate('nullable|array')]
    public $ingredients = [];
    
    #[Validate('nullable|string')]
    public $ingredients_text = '';
    
    public $is_active = true;
    public $is_featured = false;
    public $meta_title = '';
    public $meta_description = '';
    
    // Images
    public $images = [];
    public $existingImages = [];
    
    // Propriétés d'interface
    public $bulkSelected = [];
    public $selectAll = false;
    public $showFilters = false;
    public $viewMode = 'grid'; // grid, list

    protected $queryString = [
        'search' => ['except' => ''],
        'activeTab' => ['except' => 'all'],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'statusFilter' => ['except' => 'all'],
        'brandFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'viewMode' => ['except' => 'grid']
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function getProducts()
    {
        $query = Product::with(['category', 'brand', 'images']);

        // Filtrage par onglet
        if ($this->activeTab === 'parfums') {
            $query->whereHas('category', function($q) {
                $q->where('slug', 'parfums')->orWhere('parent_id', function($subQ) {
                    $subQ->select('id')->from('categories')->where('slug', 'parfums');
                });
            });
        } elseif ($this->activeTab === 'beaute') {
            $query->whereHas('category', function($q) {
                $q->where('slug', 'beaute')->orWhere('parent_id', function($subQ) {
                    $subQ->select('id')->from('categories')->where('slug', 'beaute');
                });
            });
        }

        // Recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%')
                  ->orWhereHas('brand', function($brandQ) {
                      $brandQ->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filtres
        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->brandFilter) {
            $query->where('brand_id', $this->brandFilter);
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->priceMin) {
            $query->where('price', '>=', $this->priceMin);
        }

        if ($this->priceMax) {
            $query->where('price', '<=', $this->priceMax);
        }

        // Filtre de stock
        if ($this->stockFilter === 'in_stock') {
            $query->where('stock_quantity', '>', 10);
        } elseif ($this->stockFilter === 'low_stock') {
            $query->whereBetween('stock_quantity', [1, 10]);
        } elseif ($this->stockFilter === 'out_of_stock') {
            $query->where('stock_quantity', 0);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate(12);
    }

    public function getProductStats()
    {
        return [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'inactive' => Product::where('is_active', false)->count(),
            'low_stock' => Product::whereBetween('stock_quantity', [1, 10])->count(),
            'out_of_stock' => Product::where('stock_quantity', 0)->count(),
            'parfums' => Product::whereHas('category', function($q) {
                $q->where('slug', 'parfums');
            })->count(),
            'beaute' => Product::whereHas('category', function($q) {
                $q->where('slug', 'beaute');
            })->count(),
        ];
    }

    // Actions sur les onglets
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
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

    // Gestion des filtres
    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function clearFilters()
    {
        $this->reset([
            'search', 'statusFilter', 'brandFilter', 'categoryFilter', 
            'priceMin', 'priceMax', 'stockFilter'
        ]);
        $this->resetPage();
    }

    // Gestion du mode d'affichage
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    // Gestion de la modal
    public function openModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function editProduct($productId)
    {
        $product = Product::with('images')->findOrFail($productId);
        
        $this->selectedProductId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->short_description = $product->short_description;
        $this->price = $product->price;
        $this->compare_price = $product->compare_price;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->stock_quantity = $product->stock_quantity;
        $this->sku = $product->sku;
        $this->volume = $product->volume;
        $this->ingredients_text = is_array($product->ingredients) ? implode(', ', $product->ingredients) : '';
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->meta_title = $product->meta_title;
        $this->meta_description = $product->meta_description;
        $this->existingImages = $product->images->toArray();
        
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
            'name', 'description', 'short_description', 'price', 'compare_price',
            'category_id', 'brand_id', 'stock_quantity', 'sku', 'volume',
            'ingredients_text', 'is_active', 'is_featured', 'meta_title',
            'meta_description', 'images', 'existingImages', 'selectedProductId'
        ]);
        $this->is_active = true;
        $this->is_featured = false;
    }

    // Sauvegarde du produit
    public function saveProduct()
    {
        $this->validate();

        try {
            // Préparation des données
            $data = [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'short_description' => $this->short_description,
                'price' => $this->price,
                'compare_price' => $this->compare_price ?: null,
                'category_id' => $this->category_id,
                'brand_id' => $this->brand_id,
                'stock_quantity' => $this->stock_quantity,
                'sku' => $this->sku ?: Str::upper(Str::random(8)),
                'volume' => $this->volume,
                'ingredients' => $this->ingredients_text ? explode(', ', $this->ingredients_text) : [],
                'is_active' => $this->is_active,
                'is_featured' => $this->is_featured,
                'meta_title' => $this->meta_title ?: $this->name,
                'meta_description' => $this->meta_description ?: Str::limit($this->description, 160),
            ];

            if ($this->isEditing) {
                $product = Product::findOrFail($this->selectedProductId);
                $product->update($data);
                $message = 'Produit mis à jour avec succès !';
            } else {
                $product = Product::create($data);
                $message = 'Produit créé avec succès !';
            }

            // Gestion des images
            if ($this->images) {
                foreach ($this->images as $image) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'alt_text' => $this->name,
                        'is_primary' => ProductImage::where('product_id', $product->id)->count() === 0
                    ]);
                }
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

    // Suppression de produit
    public function confirmDelete($productId)
    {
        $this->selectedProductId = $productId;
        $this->showDeleteModal = true;
    }

    public function deleteProduct()
    {
        try {
            $product = Product::findOrFail($this->selectedProductId);
            
            // Supprimer les images
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            
            $product->delete();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Produit supprimé avec succès !'
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

    // Suppression d'image existante
    public function removeExistingImage($imageId)
    {
        try {
            $image = ProductImage::findOrFail($imageId);
            Storage::disk('public')->delete($image->image_path);
            $image->delete();

            $this->existingImages = collect($this->existingImages)->reject(function($img) use ($imageId) {
                return $img['id'] == $imageId;
            })->values()->toArray();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Image supprimée !'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression de l\'image'
            ]);
        }
    }

    // Actions en lot
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->bulkSelected = $this->getProducts()->pluck('id')->toArray();
        } else {
            $this->bulkSelected = [];
        }
    }

    public function bulkActivate()
    {
        Product::whereIn('id', $this->bulkSelected)->update(['is_active' => true]);
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => count($this->bulkSelected) . ' produits activés !'
        ]);
        $this->bulkSelected = [];
        $this->selectAll = false;
    }

    public function bulkDeactivate()
    {
        Product::whereIn('id', $this->bulkSelected)->update(['is_active' => false]);
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => count($this->bulkSelected) . ' produits désactivés !'
        ]);
        $this->bulkSelected = [];
        $this->selectAll = false;
    }

    public function bulkDelete()
    {
        $products = Product::whereIn('id', $this->bulkSelected)->with('images')->get();
        
        foreach ($products as $product) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            $product->delete();
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => count($this->bulkSelected) . ' produits supprimés !'
        ]);
        
        $this->bulkSelected = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    // Dupliquer un produit
    public function duplicateProduct($productId)
    {
        try {
            $originalProduct = Product::with('images')->findOrFail($productId);
            
            $newProduct = $originalProduct->replicate();
            $newProduct->name = $originalProduct->name . ' (Copie)';
            $newProduct->slug = Str::slug($newProduct->name);
            $newProduct->sku = Str::upper(Str::random(8));
            $newProduct->is_active = false;
            $newProduct->save();

            // Dupliquer les images
            foreach ($originalProduct->images as $image) {
                $newPath = 'products/' . basename($image->image_path);
                Storage::disk('public')->copy($image->image_path, $newPath);
                
                ProductImage::create([
                    'product_id' => $newProduct->id,
                    'image_path' => $newPath,
                    'alt_text' => $image->alt_text,
                    'is_primary' => $image->is_primary
                ]);
            }

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Produit dupliqué avec succès !'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la duplication : ' . $e->getMessage()
            ]);
        }
    }

    // Toggle statut actif
    public function toggleStatus($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_active' => !$product->is_active]);
        
        $status = $product->is_active ? 'activé' : 'désactivé';
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Produit {$status} !"
        ]);
    }

    // Toggle featured
    public function toggleFeatured($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_featured' => !$product->is_featured]);
        
        $status = $product->is_featured ? 'mis en avant' : 'retiré de la mise en avant';
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Produit {$status} !"
        ]);
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

    public function updatedBrandFilter()
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = $this->getProducts();
        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::active()->orderBy('name')->get();
        $stats = $this->getProductStats();

        return view('livewire.admin.products', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'stats' => $stats
        ])->layout('layout.admin');
    }
}