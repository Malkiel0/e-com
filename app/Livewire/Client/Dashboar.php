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

class Dashboar extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $selectedBrand = '';
    public $minPrice = 0;
    public $maxPrice = 1000000;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $viewMode = 'grid'; // grid ou list
    public $showFilters = false;
    public $selectedProduct = null;
    public $showQuickView = false;

    // Propriétés pour le panier
    public $cartMessage = '';
    public $showCartSuccess = false;

    // Propriétés pour WhatsApp
    public $whatsappNumber = '2290152017507'; // À configurer

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'selectedBrand' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount()
    {
        $maxPrice = Product::active()->max('price');
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
        $this->minPrice = 0;
        $this->maxPrice = 1000000;
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

        $this->cartMessage = "✨ {$product->name} ajouté au panier avec succès !";
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
            
            // Dispatch pour gérer le scroll mais ne pas bloquer le body
            $this->dispatch('modal-opened');
        }
    }

    public function getUrlAttribute()
    {
        return route('product.show', $this->slug);  // ✅ CORRECT avec la nouvelle route
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
            // Supprimer l'ancien enregistrement
            RecentlyViewed::where('user_id', Auth::id())
                         ->where('product_id', $productId)
                         ->delete();
            
            // Créer un nouveau
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
                
                $message = "🌸 Bonjour ! Je suis intéressé(e) par ce produit :\n\n";
                $message .= "📦 *{$product->name}*\n";
                $message .= "💰 Prix : {$product->price} FCFA\n";
                $message .= "🔗 " . route('product.show', $product->slug) . "\n\n";
                $message .= "Pourriez-vous me donner plus d'informations ?";
            } else {
                $message = "🌸 Bonjour ! J'aimerais avoir des informations sur vos produits.";
            }

            // ✅ URL propre et encodée
            $encodedMessage = rawurlencode($message);
            $whatsappUrl = "https://wa.me/{$this->whatsappNumber}?text={$encodedMessage}";
            
            // 🐛 DEBUG
            \Log::info('WhatsApp Debug:', [
                'productId' => $productId,
                'message' => $message,
                'url' => $whatsappUrl,
                'whatsappNumber' => $this->whatsappNumber
            ]);
            
            // ✅ DISPATCH CORRIGÉ avec structure explicite
            $this->dispatch('open-whatsapp', 
                url: $whatsappUrl,  // ← Nouveau format Livewire
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
        // Query avec tous les scopes appropriés
        $query = Product::with(['category', 'brand', 'images', 'reviews'])
                       ->active()
                       ->inStock();

        // Recherche améliorée
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description', 'like', '%' . $this->search . '%')
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
        return Category::active()
                      ->whereHas('products', function($query) {
                          $query->active()->inStock();
                      })
                      ->orderBy('name')
                      ->get();
    }

    public function getBrandsProperty()
    {
        return Brand::active()
                   ->whereHas('products', function($query) {
                       $query->active()->inStock();
                   })
                   ->orderBy('name')
                   ->get();
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
        return view('livewire.client.dashboar', [
            'products' => $this->products,
            'categories' => $this->categories,
            'brands' => $this->brands,
            'userWishlist' => $this->userWishlist,
        ])->layout('layout.client');
    }
}