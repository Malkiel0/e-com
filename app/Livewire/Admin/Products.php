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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class Products extends Component
{
    use WithPagination, WithFileUploads;

    // Propriétés de filtrage et recherche
    public $search = '';
    public $activeTab = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $statusFilter = 'all';
    public $brandFilter = '';
    public $categoryFilter = '';
    public $priceMin = '';
    public $priceMax = '';
    public $stockFilter = 'all';

    // Propriétés de modal et édition
    public $showModal = false;
    public $showDeleteModal = false;
    public $isEditing = false;
    public $selectedProductId = null;

    // Propriétés du formulaire produit - Alignées avec la migration
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('required|string')]
    public $description = '';
    
    #[Validate('nullable|string')]
    public $short_description = '';
    
    #[Validate('required|numeric|min:0')]
    public $price = '';
    
    #[Validate('nullable|numeric|min:0')]
    public $original_price = ''; // Correspond à la migration
    
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
    
    #[Validate('nullable|string|max:100')]
    public $concentration = '';
    
    #[Validate('nullable|string')]
    public $ingredients_text = '';
    
    #[Validate('nullable|string')]
    public $skin_type = '';
    
    public $status = 'active'; // Correspond à la migration
    public $is_featured = false;
    public $is_new = false;
    public $is_bestseller = false;
    public $meta_title = '';
    public $meta_description = '';
    
    // Images
    public $images = [];
    public $existingImages = [];
    
    // Propriétés d'interface
    public $bulkSelected = [];
    public $selectAll = false;
    public $showFilters = false;
    public $viewMode = 'grid';

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

    // Messages d'erreur personnalisés
    protected $messages = [
        'name.required' => 'Le nom du produit est obligatoire.',
        'name.max' => 'Le nom du produit ne peut pas dépasser 255 caractères.',
        'description.required' => 'La description est obligatoire.',
        'price.required' => 'Le prix est obligatoire.',
        'price.numeric' => 'Le prix doit être un nombre.',
        'price.min' => 'Le prix doit être supérieur ou égal à 0.',
        'original_price.numeric' => 'Le prix original doit être un nombre.',
        'original_price.min' => 'Le prix original doit être supérieur ou égal à 0.',
        'category_id.required' => 'La catégorie est obligatoire.',
        'category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
        'brand_id.required' => 'La marque est obligatoire.',
        'brand_id.exists' => 'La marque sélectionnée n\'existe pas.',
        'stock_quantity.required' => 'La quantité en stock est obligatoire.',
        'stock_quantity.integer' => 'La quantité en stock doit être un nombre entier.',
        'stock_quantity.min' => 'La quantité en stock doit être supérieure ou égale à 0.',
        'sku.max' => 'Le SKU ne peut pas dépasser 50 caractères.',
        'volume.max' => 'Le volume ne peut pas dépasser 50 caractères.',
        'concentration.max' => 'La concentration ne peut pas dépasser 100 caractères.',
    ];

    // Règles de validation
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50',
            'volume' => 'nullable|string|max:50',
            'concentration' => 'nullable|string|max:100',
            'ingredients_text' => 'nullable|string',
            'skin_type' => 'nullable|string',
            'status' => 'required|in:active,inactive,draft,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];
    }

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
            $query->where('status', 'active');
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('status', 'inactive');
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
            'active' => Product::where('status', 'active')->count(),
            'inactive' => Product::where('status', 'inactive')->count(),
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
        try {
            $product = Product::with('images')->findOrFail($productId);
            
            $this->selectedProductId = $product->id;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->short_description = $product->short_description;
            $this->price = $product->price;
            $this->original_price = $product->original_price;
            $this->category_id = $product->category_id;
            $this->brand_id = $product->brand_id;
            $this->stock_quantity = $product->stock_quantity;
            $this->sku = $product->sku;
            $this->volume = $product->volume;
            $this->concentration = $product->concentration;
            $this->ingredients_text = is_array($product->ingredients) ? 
                implode(', ', $product->ingredients) : ($product->ingredients ?? '');
            $this->skin_type = $product->skin_type;
            $this->status = $product->status;
            $this->is_featured = $product->is_featured;
            $this->is_new = $product->is_new;
            $this->is_bestseller = $product->is_bestseller;
            $this->meta_title = $product->meta_title;
            $this->meta_description = $product->meta_description;
            
            // Charger les images existantes correctement
            $this->existingImages = $product->images->map(function($image) {
                return [
                    'id' => $image->id,
                    'file_path' => $image->file_path,
                    'is_primary' => $image->is_primary,
                    'alt_text' => $image->alt_text
                ];
            })->toArray();
            
            $this->isEditing = true;
            $this->showModal = true;

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors du chargement du produit : ' . $e->getMessage()
            ]);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'description', 'short_description', 'price', 'original_price',
            'category_id', 'brand_id', 'stock_quantity', 'sku', 'volume',
            'concentration', 'ingredients_text', 'skin_type', 'meta_title',
            'meta_description', 'images', 'existingImages', 'selectedProductId'
        ]);
        
        // Valeurs par défaut
        $this->status = 'active';
        $this->is_featured = false;
        $this->is_new = false;
        $this->is_bestseller = false;
        
        // Réinitialiser les erreurs
        $this->resetValidation();
    }

    // Sauvegarde du produit - VERSION CORRIGÉE
    public function saveProduct()
    {
        // Validation personnalisée pour les images
        if ($this->images && count($this->images) > 10) {
            $this->addError('images', 'Vous ne pouvez pas télécharger plus de 10 images.');
            return;
        }

        // Validation des types et tailles d'images
        if ($this->images) {
            foreach ($this->images as $index => $image) {
                if (!$image->isValid()) {
                    $this->addError("images.{$index}", 'Le fichier n\'est pas valide.');
                    return;
                }
                
                if ($image->getSize() > 10240 * 1024) { // 10MB en bytes
                    $this->addError("images.{$index}", 'L\'image ne peut pas dépasser 10 Mo.');
                    return;
                }
                
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                if (!in_array($image->getMimeType(), $allowedTypes)) {
                    $this->addError("images.{$index}", 'Le format d\'image n\'est pas autorisé. Utilisez: JPEG, PNG, JPG, GIF, WebP.');
                    return;
                }
            }
        }

        // Validation complète des autres champs
        $validatedData = $this->validate();

        DB::beginTransaction();

        try {
            // Préparation des données alignées avec la migration
            $data = [
                'name' => $this->name,
                'slug' => $this->generateUniqueSlug($this->name),
                'description' => $this->description,
                'short_description' => $this->short_description,
                'price' => $this->price,
                'original_price' => $this->original_price ?: null,
                'category_id' => $this->category_id,
                'brand_id' => $this->brand_id,
                'stock_quantity' => $this->stock_quantity,
                'sku' => $this->sku ?: $this->generateUniqueSku(),
                'volume' => $this->volume,
                'concentration' => $this->concentration,
                'ingredients' => $this->ingredients_text ? 
                    array_map('trim', explode(',', $this->ingredients_text)) : [],
                'skin_type' => $this->skin_type,
                'status' => $this->status,
                'is_featured' => $this->is_featured,
                'is_new' => $this->is_new,
                'is_bestseller' => $this->is_bestseller,
                'meta_title' => $this->meta_title ?: $this->name,
                'meta_description' => $this->meta_description ?: 
                    Str::limit(strip_tags($this->description), 160),
                'low_stock_threshold' => 5,
                'track_stock' => true,
                'stock_status' => $this->stock_quantity > 0 ? 'in_stock' : 'out_of_stock',
            ];

            // Créer ou mettre à jour le produit
            if ($this->isEditing) {
                $product = Product::findOrFail($this->selectedProductId);
                $product->update($data);
                $message = 'Produit mis à jour avec succès !';
            } else {
                $product = Product::create($data);
                $message = 'Produit créé avec succès !';
            }

            // Gestion des images
            $this->handleImages($product);

            DB::commit();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => $message
            ]);

            $this->closeModal();
            $this->resetPage();

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // Les erreurs de validation seront affichées automatiquement
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la sauvegarde : ' . $e->getMessage()
            ]);
        }
    }

    // Gestion des images - VERSION CORRIGÉE
    private function handleImages($product)
    {
        if (!$this->images || count($this->images) === 0) {
            return;
        }

        $isFirstImage = $product->images()->count() === 0;

        foreach ($this->images as $index => $image) {
            try {
                // Vérifier que le fichier est valide
                if (!$image || !$image->isValid()) {
                    continue;
                }
                
                // Stocker l'image
                $path = $image->store('products', 'public');
                
                // Obtenir les dimensions de l'image de manière sécurisée
                $width = null;
                $height = null;
                
                try {
                    $imageSize = getimagesize($image->getRealPath());
                    if ($imageSize !== false) {
                        $width = $imageSize[0];
                        $height = $imageSize[1];
                    }
                } catch (\Exception $e) {
                    // Ignorer l'erreur de taille d'image, continuer sans dimensions
                    logger()->warning('Impossible d\'obtenir les dimensions de l\'image: ' . $e->getMessage());
                }
                
                // Créer l'enregistrement en base - Aligné avec la migration
                ProductImage::create([
                    'product_id' => $product->id,
                    'original_name' => $image->getClientOriginalName(),
                    'file_name' => basename($path),
                    'file_path' => $path,
                    'mime_type' => $image->getMimeType(),
                    'file_size' => $image->getSize(),
                    'width' => $width,
                    'height' => $height,
                    'alt_text' => $product->name,
                    'sort_order' => $index,
                    'is_primary' => $isFirstImage && $index === 0,
                    'is_active' => true,
                ]);

            } catch (\Exception $e) {
                // Log l'erreur mais continue avec les autres images
                logger()->error('Erreur lors du traitement de l\'image ' . ($index + 1) . ': ' . $e->getMessage());
                
                // Supprimer le fichier si il a été créé mais l'enregistrement a échoué
                if (isset($path) && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
    }

    // Génération d'un slug unique
    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Product::where('slug', $slug)
            ->when($this->isEditing, function($query) {
                return $query->where('id', '!=', $this->selectedProductId);
            })->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Génération d'un SKU unique
    private function generateUniqueSku()
    {
        do {
            $sku = strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)
            ->when($this->isEditing, function($query) {
                return $query->where('id', '!=', $this->selectedProductId);
            })->exists());

        return $sku;
    }

    // Suppression de produit
    public function confirmDelete($productId)
    {
        $this->selectedProductId = $productId;
        $this->showDeleteModal = true;
    }

    public function deleteProduct()
    {
        DB::beginTransaction();

        try {
            $product = Product::with('images')->findOrFail($this->selectedProductId);
            
            // Supprimer les images physiques et en base
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->file_path)) {
                    Storage::disk('public')->delete($image->file_path);
                }
                $image->delete();
            }
            
            // Supprimer le produit
            $product->delete();

            DB::commit();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Produit supprimé avec succès !'
            ]);

            $this->showDeleteModal = false;
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ]);
        }
    }

    // Suppression d'image existante
    public function removeExistingImage($imageId)
    {
        DB::beginTransaction();

        try {
            $image = ProductImage::findOrFail($imageId);
            
            // Supprimer le fichier physique
            if (Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }
            
            // Supprimer de la base
            $image->delete();

            // Mettre à jour la liste des images existantes
            $this->existingImages = collect($this->existingImages)
                ->reject(function($img) use ($imageId) {
                    return $img['id'] == $imageId;
                })
                ->values()
                ->toArray();

            DB::commit();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Image supprimée avec succès !'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression de l\'image : ' . $e->getMessage()
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
        try {
            Product::whereIn('id', $this->bulkSelected)
                ->update(['status' => 'active']);
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => count($this->bulkSelected) . ' produit(s) activé(s) !'
            ]);
            
            $this->bulkSelected = [];
            $this->selectAll = false;
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de l\'activation : ' . $e->getMessage()
            ]);
        }
    }

    public function bulkDeactivate()
    {
        try {
            Product::whereIn('id', $this->bulkSelected)
                ->update(['status' => 'inactive']);
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => count($this->bulkSelected) . ' produit(s) désactivé(s) !'
            ]);
            
            $this->bulkSelected = [];
            $this->selectAll = false;
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la désactivation : ' . $e->getMessage()
            ]);
        }
    }

    public function bulkDelete()
    {
        DB::beginTransaction();

        try {
            $products = Product::whereIn('id', $this->bulkSelected)
                ->with('images')
                ->get();
            
            foreach ($products as $product) {
                // Supprimer les images
                foreach ($product->images as $image) {
                    if (Storage::disk('public')->exists($image->file_path)) {
                        Storage::disk('public')->delete($image->file_path);
                    }
                }
                $product->delete();
            }

            DB::commit();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => count($this->bulkSelected) . ' produit(s) supprimé(s) !'
            ]);
            
            $this->bulkSelected = [];
            $this->selectAll = false;
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ]);
        }
    }

    // Dupliquer un produit
    public function duplicateProduct($productId)
    {
        DB::beginTransaction();

        try {
            $originalProduct = Product::with('images')->findOrFail($productId);
            
            $newProduct = $originalProduct->replicate();
            $newProduct->name = $originalProduct->name . ' (Copie)';
            $newProduct->slug = $this->generateUniqueSlug($newProduct->name);
            $newProduct->sku = $this->generateUniqueSku();
            $newProduct->status = 'inactive';
            $newProduct->save();

            // Dupliquer les images
            foreach ($originalProduct->images as $image) {
                $newPath = 'products/' . Str::random(40) . '.' . 
                    pathinfo($image->file_path, PATHINFO_EXTENSION);
                
                if (Storage::disk('public')->copy($image->file_path, $newPath)) {
                    ProductImage::create([
                        'product_id' => $newProduct->id,
                        'original_name' => $image->original_name,
                        'file_name' => basename($newPath),
                        'file_path' => $newPath,
                        'mime_type' => $image->mime_type,
                        'file_size' => $image->file_size,
                        'width' => $image->width,
                        'height' => $image->height,
                        'alt_text' => $image->alt_text,
                        'sort_order' => $image->sort_order,
                        'is_primary' => $image->is_primary,
                        'is_active' => $image->is_active,
                    ]);
                }
            }

            DB::commit();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Produit dupliqué avec succès !'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la duplication : ' . $e->getMessage()
            ]);
        }
    }

    // Toggle statut actif
    public function toggleStatus($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $newStatus = $product->status === 'active' ? 'inactive' : 'active';
            $product->update(['status' => $newStatus]);
            
            $statusText = $newStatus === 'active' ? 'activé' : 'désactivé';
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => "Produit {$statusText} avec succès !"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors du changement de statut : ' . $e->getMessage()
            ]);
        }
    }

    // Toggle featured
    public function toggleFeatured($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->update(['is_featured' => !$product->is_featured]);
            
            $status = $product->is_featured ? 'mis en avant' : 'retiré de la mise en avant';
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => "Produit {$status} avec succès !"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors du changement de statut vedette : ' . $e->getMessage()
            ]);
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
        try {
            $products = $this->getProducts();
            $categories = Category::where('is_active', true)->orderBy('name')->get();
            $brands = Brand::where('is_active', true)->orderBy('name')->get();
            $stats = $this->getProductStats();

            return view('livewire.admin.products', [
                'products' => $products,
                'categories' => $categories,
                'brands' => $brands,
                'stats' => $stats
            ])->layout('layout.admin');

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors du chargement des données : ' . $e->getMessage()
            ]);
            
            return view('livewire.admin.products', [
                'products' => collect(),
                'categories' => collect(),
                'brands' => collect(),
                'stats' => []
            ])->layout('layout.admin');
        }
    }
}