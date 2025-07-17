<?php
namespace App\Livewire\Client;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Models\RecentlyViewed;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ProduitsDeBeauté extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $selectedBrand = '';
    public $minPrice = 0;
    public $maxPrice = 1000000;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $viewMode = 'grid';
    public $showFilters = false;
    public $selectedProduct = null;
    public $showQuickView = false;

    // Filtres spécifiques beauté
    public $selectedSkinType = '';
    public $selectedBeautyCategory = '';

    // Propriétés pour le panier
    public $cartMessage = '';
    public $showCartSuccess = false;

    // Propriétés pour WhatsApp
    public $whatsappNumber = '2290152017507';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'selectedBrand' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'selectedSkinType' => ['except' => ''],
    ];

    public function mount()
    {
        // Récupérer le prix max des produits de beauté uniquement
        $beautyCategories = Category::where('name', 'NOT LIKE', '%parfum%')
                                  ->where('name', 'NOT LIKE', '%fragrance%')
                                  ->where('name', 'NOT LIKE', '%eau de%')
                                  ->pluck('id');
        
        $maxPrice = Product::whereIn('category_id', $beautyCategories)->active()->max('price');
        $this->maxPrice = $maxPrice ?? 1000000;
        
        // S'assurer que minPrice est toujours inférieur à maxPrice
        if ($this->minPrice >= $this->maxPrice) {
            $this->minPrice = 0;
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatedSelectedBrand()
    {
        $this->resetPage();
    }

    public function updatedSelectedSkinType()
    {
        $this->resetPage();
    }

    public function updatedMinPrice()
    {
        // S'assurer que minPrice ne dépasse pas maxPrice
        if ($this->minPrice > $this->maxPrice) {
            $this->minPrice = $this->maxPrice;
        }
        $this->resetPage();
    }

    public function updatedMaxPrice()
    {
        // S'assurer que maxPrice ne soit pas inférieur à minPrice
        if ($this->maxPrice < $this->minPrice) {
            $this->maxPrice = $this->minPrice;
        }
        $this->resetPage();
    }

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

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedCategory = '';
        $this->selectedBrand = '';
        $this->selectedSkinType = '';
        $this->minPrice = 0;
        
        // ✅ Recalculer le prix max lors du reset (comme Parfums)
        $beautyCategories = Category::where('name', 'NOT LIKE', '%parfum%')
                                  ->where('name', 'NOT LIKE', '%fragrance%')
                                  ->where('name', 'NOT LIKE', '%eau de%')
                                  ->pluck('id');
        
        $maxPrice = Product::whereIn('category_id', $beautyCategories)->active()->max('price');
        $this->maxPrice = $maxPrice ?? 1000000;
        
        $this->sortBy = 'name';
        $this->sortDirection = 'asc';
        $this->resetPage();
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            $this->cartMessage = 'Produit introuvable';
            $this->showCartSuccess = true;
            return;
        }

        if (!$product->is_in_stock) {
            $this->cartMessage = 'Produit en rupture de stock';
            $this->showCartSuccess = true;
            return;
        }

        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                              ->where('product_id', $productId)
                              ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            $sessionId = session()->getId();
            $cartItem = CartItem::where('session_id', $sessionId)
                              ->where('product_id', $productId)
                              ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'session_id' => $sessionId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }

        $this->cartMessage = "💄 {$product->name} ajouté au panier avec succès !";
        $this->showCartSuccess = true;
        
        $this->dispatch('cart-updated');
    }

    public function toggleWishlist($productId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-modal');
            return;
        }

        $wishlistItem = Wishlist::where('user_id', Auth::id())
                              ->where('product_id', $productId)
                              ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $message = 'Retiré des favoris';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
            $message = 'Ajouté aux favoris';
        }

        session()->flash('wishlist_message', $message);
    }

    public function viewProduct($productId)
    {
        $product = Product::with(['category', 'brand', 'images', 'reviews.user'])
                         ->find($productId);
        
        if ($product) {
            $this->selectedProduct = $product;
            $this->showQuickView = true;
            
            $this->recordProductView($productId);
            
            // ✅ Dispatch pour gérer le scroll et s'assurer que la modal est visible
            $this->dispatch('modal-opened');
        }
    }

    public function closeQuickView()
    {
        $this->showQuickView = false;
        $this->selectedProduct = null;
        
        // Dispatch pour rétablir le scroll du body
        $this->dispatch('modal-closed');
    }

    public function recordProductView($productId)
    {
        if (Auth::check()) {
            RecentlyViewed::where('user_id', Auth::id())
                         ->where('product_id', $productId)
                         ->delete();
            
            RecentlyViewed::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'viewed_at' => now(),
            ]);
        } else {
            $sessionId = session()->getId();
            RecentlyViewed::where('session_id', $sessionId)
                         ->where('product_id', $productId)
                         ->delete();
            
            RecentlyViewed::create([
                'session_id' => $sessionId,
                'product_id' => $productId,
                'viewed_at' => now(),
            ]);
        }
    }

    public function contactWhatsApp($productId = null)
    {
        try {
            if ($productId) {
                $product = Product::find($productId);
                if (!$product) {
                    session()->flash('error', 'Produit non trouvé');
                    return;
                }
                
                $message = "💄 Bonjour ! Je suis intéressé(e) par ce produit de beauté :\n\n";
                $message .= "✨ *{$product->name}*\n";
                $message .= "💰 Prix : {$product->price} FCFA\n";
                if ($product->skin_type) {
                    $message .= "🌟 Type de peau : {$product->skin_type}\n";
                }
                if ($product->category) {
                    $message .= "💄 Catégorie : {$product->category->name}\n";
                }
                $message .= "🔗 " . route('product.show', $product->slug) . "\n\n";
                $message .= "Pourriez-vous me donner plus d'informations sur ce produit ?";
            } else {
                $message = "💄 Bonjour ! J'aimerais découvrir votre collection de produits de beauté.";
            }

            // ✅ URL propre et encodée (comme Dashboar et Parfums)
            $encodedMessage = rawurlencode($message);
            $whatsappUrl = "https://wa.me/{$this->whatsappNumber}?text={$encodedMessage}";
            
            // ✅ DISPATCH CORRIGÉ avec structure explicite
            $this->dispatch('open-whatsapp', 
                url: $whatsappUrl,
                message: $message,
                debug: 'URL générée avec succès'
            );
            
        } catch (\Exception $e) {
            \Log::error('Erreur WhatsApp:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Erreur lors de la génération du lien WhatsApp');
        }
    }

    public function getProductsProperty()
    {
        // Récupérer uniquement les catégories de beauté (exclure parfums)
        $beautyCategories = Category::where('name', 'NOT LIKE', '%parfum%')
                                  ->where('name', 'NOT LIKE', '%fragrance%')
                                  ->where('name', 'NOT LIKE', '%eau de%')
                                  ->pluck('id');

        // ✅ Query optimisée (comme Parfums) - Supprimé inStock() pour inclure tous les produits actifs
        $query = Product::with(['category', 'brand', 'images', 'reviews'])
                       ->whereIn('category_id', $beautyCategories)
                       ->active();

        // Recherche améliorée
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description', 'like', '%' . $this->search . '%')
                  ->orWhere('skin_type', 'like', '%' . $this->search . '%')
                  ->orWhereHas('brand', function($brandQuery) {
                      $brandQuery->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('category', function($catQuery) {
                      $catQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filtres
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->selectedBrand) {
            $query->where('brand_id', $this->selectedBrand);
        }

        if ($this->selectedSkinType) {
            $query->where('skin_type', $this->selectedSkinType);
        }

        // Prix avec validation
        $minPrice = max(0, $this->minPrice);
        $maxPrice = max($minPrice, $this->maxPrice);
        $query->whereBetween('price', [$minPrice, $maxPrice]);

        // Tri amélioré
        switch ($this->sortBy) {
            case 'price':
                $query->orderBy('price', $this->sortDirection);
                break;
            case 'name':
                $query->orderBy('name', $this->sortDirection);
                break;
            case 'created_at':
                $query->orderBy('created_at', $this->sortDirection);
                break;
            case 'rating':
                $query->orderBy('rating_average', $this->sortDirection);
                break;
            case 'sales':
                $query->orderBy('sales_count', $this->sortDirection);
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        return $query->paginate(12);
    }

    public function getCategoriesProperty()
    {
        // Récupérer uniquement les catégories de beauté
        return Category::where('name', 'NOT LIKE', '%parfum%')
                      ->where('name', 'NOT LIKE', '%fragrance%')
                      ->where('name', 'NOT LIKE', '%eau de%')
                      ->active()
                      ->whereHas('products', function($query) {
                          $query->active();
                      })
                      ->orderBy('name')
                      ->get();
    }

    public function getBrandsProperty()
    {
        // Récupérer uniquement les marques qui ont des produits de beauté actifs
        $beautyCategories = Category::where('name', 'NOT LIKE', '%parfum%')
                                  ->where('name', 'NOT LIKE', '%fragrance%')
                                  ->where('name', 'NOT LIKE', '%eau de%')
                                  ->pluck('id');

        return Brand::active()
                   ->whereHas('products', function($query) use ($beautyCategories) {
                       $query->whereIn('category_id', $beautyCategories)->active();
                   })
                   ->orderBy('name')
                   ->get();
    }

    public function getSkinTypesProperty()
    {
        $beautyCategories = Category::where('name', 'NOT LIKE', '%parfum%')
                                  ->where('name', 'NOT LIKE', '%fragrance%')
                                  ->where('name', 'NOT LIKE', '%eau de%')
                                  ->pluck('id');

        return Product::whereIn('category_id', $beautyCategories)
                     ->active()
                     ->whereNotNull('skin_type')
                     ->where('skin_type', '!=', '')
                     ->distinct()
                     ->pluck('skin_type')
                     ->filter()
                     ->sort()
                     ->values();
    }

    public function getUserWishlistProperty()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }
        return [];
    }

    #[On('hide-cart-success')]
    public function hideCartSuccess()
    {
        $this->showCartSuccess = false;
    }

    public function render()
    {
        return view('livewire.client.produits-de-beauté', [
            'products' => $this->products,
            'categories' => $this->categories,
            'brands' => $this->brands,
            'skinTypes' => $this->skinTypes,
            'userWishlist' => $this->userWishlist,
        ])->layout('layout.client');
    }
}