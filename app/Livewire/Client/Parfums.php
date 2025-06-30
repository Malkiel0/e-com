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

class Parfums extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedBrand = '';
    public $minPrice = 0;
    public $maxPrice = 1000;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $viewMode = 'grid';
    public $showFilters = false;
    public $selectedProduct = null;
    public $showQuickView = false;

    // Filtres spécifiques parfums
    public $selectedConcentration = '';
    public $selectedVolume = '';
    public $selectedFragranceFamily = '';

    // Propriétés pour le panier
    public $cartMessage = '';
    public $showCartSuccess = false;

    // Propriétés pour WhatsApp
    public $whatsappNumber = '2290190927406';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedBrand' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'selectedConcentration' => ['except' => ''],
        'selectedVolume' => ['except' => ''],
    ];

    public function mount()
    {
        // Récupérer le prix max des parfums uniquement
        $parfumCategories = Category::where('name', 'LIKE', '%parfum%')
                                  ->orWhere('name', 'LIKE', '%fragrance%')
                                  ->pluck('id');
        
        $this->maxPrice = Product::whereIn('category_id', $parfumCategories)->max('price') ?? 1000;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedBrand()
    {
        $this->resetPage();
    }

    public function updatedSelectedConcentration()
    {
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

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            $this->cartMessage = 'Produit introuvable';
            return;
        }

        if (!$product->is_in_stock) {
            $this->cartMessage = 'Produit en rupture de stock';
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

        $this->cartMessage = "🌸 {$product->name} ajouté au panier !";
        $this->showCartSuccess = true;
        
        $this->dispatch('hide-cart-success');
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
        }
    }

    public function closeQuickView()
    {
        $this->showQuickView = false;
        $this->selectedProduct = null;
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
        if ($productId) {
            $product = Product::find($productId);
            $message = "🌸 Bonjour ! Je suis intéressé(e) par ce parfum :\n\n";
            $message .= "🌺 *{$product->name}*\n";
            $message .= "💰 Prix : {$product->price}€\n";
            if ($product->volume) {
                $message .= "💎 Volume : {$product->volume}\n";
            }
            if ($product->concentration) {
                $message .= "✨ Concentration : {$product->concentration}\n";
            }
            $message .= "🔗 " . route('product.show', $product->slug) . "\n\n";
            $message .= "Pourriez-vous me donner plus d'informations sur ce parfum ?";
        } else {
            $message = "🌸 Bonjour ! J'aimerais découvrir votre collection de parfums.";
        }

        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/{$this->whatsappNumber}?text={$encodedMessage}";
        
        $this->dispatch('open-whatsapp', ['url' => $whatsappUrl]);
    }

    public function getProductsProperty()
    {
        // Récupérer uniquement les catégories de parfums
        $parfumCategories = Category::where('name', 'LIKE', '%parfum%')
                                  ->orWhere('name', 'LIKE', '%fragrance%')
                                  ->orWhere('name', 'LIKE', '%eau de%')
                                  ->pluck('id');

        $query = Product::with(['category', 'brand', 'images', 'reviews'])
                       ->active()
                       ->inStock()
                       ->whereIn('category_id', $parfumCategories);

        // Recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('brand', function($brandQuery) {
                      $brandQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filtres spécifiques parfums
        if ($this->selectedBrand) {
            $query->where('brand_id', $this->selectedBrand);
        }

        if ($this->selectedConcentration) {
            $query->where('concentration', $this->selectedConcentration);
        }

        if ($this->selectedVolume) {
            $query->where('volume', $this->selectedVolume);
        }

        // Prix
        $query->whereBetween('price', [$this->minPrice, $this->maxPrice]);

        // Tri
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

    public function getBrandsProperty()
    {
        // Récupérer uniquement les marques qui ont des parfums
        $parfumCategories = Category::where('name', 'LIKE', '%parfum%')
                                  ->orWhere('name', 'LIKE', '%fragrance%')
                                  ->orWhere('name', 'LIKE', '%eau de%')
                                  ->pluck('id');

        return Brand::active()
                   ->whereHas('products', function($query) use ($parfumCategories) {
                       $query->whereIn('category_id', $parfumCategories)->active();
                   })
                   ->orderBy('name')
                   ->get();
    }

    public function getConcentrationsProperty()
    {
        $parfumCategories = Category::where('name', 'LIKE', '%parfum%')
                                  ->orWhere('name', 'LIKE', '%fragrance%')
                                  ->orWhere('name', 'LIKE', '%eau de%')
                                  ->pluck('id');

        return Product::whereIn('category_id', $parfumCategories)
                     ->active()
                     ->whereNotNull('concentration')
                     ->distinct()
                     ->pluck('concentration')
                     ->filter()
                     ->sort()
                     ->values();
    }

    public function getVolumesProperty()
    {
        $parfumCategories = Category::where('name', 'LIKE', '%parfum%')
                                  ->orWhere('name', 'LIKE', '%fragrance%')
                                  ->orWhere('name', 'LIKE', '%eau de%')
                                  ->pluck('id');

        return Product::whereIn('category_id', $parfumCategories)
                     ->active()
                     ->whereNotNull('volume')
                     ->distinct()
                     ->pluck('volume')
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
        return view('livewire.client.parfums', [
            'products' => $this->products,
            'brands' => $this->brands,
            'concentrations' => $this->concentrations,
            'volumes' => $this->volumes,
            'userWishlist' => $this->userWishlist,
        ])->layout('layout.client');
    }
}