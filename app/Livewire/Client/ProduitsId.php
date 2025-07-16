<?php
namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Models\RecentlyViewed;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ProduitsId extends Component
{
    public $productId;
    public $product;
    public $selectedImageIndex = 0;
    public $quantity = 1;
    public $showImageZoom = false;
    public $zoomImageUrl = '';
    
    // Propriétés pour les avis
    public $showReviewForm = false;
    public $reviewRating = 5;
    public $reviewTitle = '';
    public $reviewComment = '';
    
    // Propriétés pour le panier
    public $cartMessage = '';
    public $showCartSuccess = false;
    
    // Propriétés pour les recommandations
    public $relatedProducts = [];
    public $recentlyViewedProducts = [];
    
    // Propriétés WhatsApp
    public $whatsappNumber = '2290152017507';

    public function mount(Product $product = null, $id = null)
{
    if ($product && $product->exists) {
        // Route avec slug : /produits/{product:slug}
        $this->productId = $product->id;
        $this->product = $product;
    } elseif ($id) {
        // Route avec ID : /produits/{id}
        $this->productId = $id;
    }
    
    if (!$this->product) {
        $this->loadProduct();
    }
}

    public function loadProduct()
    {
        $this->product = Product::with([
            'category', 
            'brand', 
            'images' => function($query) {
                $query->orderBy('sort_order');
            }, 
            'reviews' => function($query) {
                $query->approved()->with('user')->latest();
            },
            'reviews.user'
        ])->find($this->productId);

        if (!$this->product) {
            abort(404);
        }

        // Enregistrer la vue
        $this->recordProductView();
        
        // Charger les produits connexes
        $this->loadRelatedProducts();
        
        // Charger les vus récemment
        $this->loadRecentlyViewed();
    }

    public function recordProductView()
    {
        if (Auth::check()) {
            // Supprimer l'ancien enregistrement
            RecentlyViewed::where('user_id', Auth::id())
                         ->where('product_id', $this->product->id)
                         ->delete();
            
            // Créer un nouveau
            RecentlyViewed::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id,
                'viewed_at' => now(),
            ]);
        } else {
            $sessionId = session()->getId();
            RecentlyViewed::where('session_id', $sessionId)
                         ->where('product_id', $this->product->id)
                         ->delete();
            
            RecentlyViewed::create([
                'session_id' => $sessionId,
                'product_id' => $this->product->id,
                'viewed_at' => now(),
            ]);
        }

        // Incrémenter le compteur de vues
        $this->product->increment('views_count');
    }

    public function loadRelatedProducts()
    {
        $this->relatedProducts = Product::with(['category', 'brand', 'images'])
                                       ->where('category_id', $this->product->category_id)
                                       ->where('id', '!=', $this->product->id)
                                       ->active()
                                       ->inStock()
                                       ->limit(4)
                                       ->get();
    }

    public function loadRecentlyViewed()
    {
        if (Auth::check()) {
            $this->recentlyViewedProducts = Product::with(['category', 'brand', 'images'])
                                                  ->whereHas('recentlyViewed', function($query) {
                                                      $query->where('user_id', Auth::id());
                                                  })
                                                  ->where('id', '!=', $this->product->id)
                                                  ->limit(4)
                                                  ->get();
        } else {
            $sessionId = session()->getId();
            $this->recentlyViewedProducts = Product::with(['category', 'brand', 'images'])
                                                  ->whereHas('recentlyViewed', function($query) use ($sessionId) {
                                                      $query->where('session_id', $sessionId);
                                                  })
                                                  ->where('id', '!=', $this->product->id)
                                                  ->limit(4)
                                                  ->get();
        }
    }

    public function selectImage($index)
    {
        $this->selectedImageIndex = $index;
    }

    public function showZoom($imageUrl)
    {
        $this->zoomImageUrl = $imageUrl;
        $this->showImageZoom = true;
    }

    public function closeZoom()
    {
        $this->showImageZoom = false;
        $this->zoomImageUrl = '';
    }

    public function incrementQuantity()
    {
        if ($this->product->track_stock && $this->quantity >= $this->product->stock_quantity) {
            return;
        }
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        if (!$this->product->is_in_stock) {
            $this->cartMessage = 'Produit en rupture de stock';
            return;
        }

        if ($this->product->track_stock && $this->quantity > $this->product->stock_quantity) {
            $this->cartMessage = 'Quantité demandée non disponible';
            return;
        }

        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                              ->where('product_id', $this->product->id)
                              ->first();

            if ($cartItem) {
                $cartItem->quantity += $this->quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $this->product->id,
                    'quantity' => $this->quantity,
                ]);
            }
        } else {
            $sessionId = session()->getId();
            $cartItem = CartItem::where('session_id', $sessionId)
                              ->where('product_id', $this->product->id)
                              ->first();

            if ($cartItem) {
                $cartItem->quantity += $this->quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'session_id' => $sessionId,
                    'product_id' => $this->product->id,
                    'quantity' => $this->quantity,
                ]);
            }
        }

        $categoryIcon = strpos(strtolower($this->product->category->name), 'parfum') !== false ? '🌸' : '💄';
        $this->cartMessage = "{$categoryIcon} {$this->product->name} ajouté au panier !";
        $this->showCartSuccess = true;
        
        $this->dispatch('hide-cart-success');
        $this->dispatch('cart-updated');
    }

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-modal');
            return;
        }

        $wishlistItem = Wishlist::where('user_id', Auth::id())
                              ->where('product_id', $this->product->id)
                              ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $this->product->decrement('wishlist_count');
            $message = 'Retiré des favoris';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id,
            ]);
            $this->product->increment('wishlist_count');
            $message = 'Ajouté aux favoris';
        }

        session()->flash('wishlist_message', $message);
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-modal');
            return;
        }

        $this->validate([
            'reviewRating' => 'required|integer|min:1|max:5',
            'reviewTitle' => 'required|string|max:255',
            'reviewComment' => 'required|string|min:10|max:1000',
        ]);

        // Vérifier si l'utilisateur a déjà laissé un avis
        $existingReview = ProductReview::where('product_id', $this->product->id)
                                     ->where('user_id', Auth::id())
                                     ->first();

        if ($existingReview) {
            session()->flash('error', 'Vous avez déjà laissé un avis pour ce produit');
            return;
        }

        ProductReview::create([
            'product_id' => $this->product->id,
            'user_id' => Auth::id(),
            'rating' => $this->reviewRating,
            'title' => $this->reviewTitle,
            'comment' => $this->reviewComment,
            'is_verified_purchase' => false, // À implémenter selon votre logique
        ]);

        // Recalculer la note moyenne
        $this->product->updateRating();

        // Reset du formulaire
        $this->reviewRating = 5;
        $this->reviewTitle = '';
        $this->reviewComment = '';
        $this->showReviewForm = false;

        session()->flash('success', 'Votre avis a été soumis et sera modéré avant publication');
        
        // Recharger le produit pour afficher les nouveaux avis
        $this->loadProduct();
    }

    public function contactWhatsApp()
    {
        $categoryIcon = strpos(strtolower($this->product->category->name), 'parfum') !== false ? '🌸' : '💄';
        
        $message = "{$categoryIcon} Bonjour ! Je suis intéressé(e) par ce produit :\n\n";
        $message .= "✨ *{$this->product->name}*\n";
        $message .= "🏷️ Marque : {$this->product->brand->name}\n";
        $message .= "💰 Prix : {$this->product->price} FCFA\n";
        
        if ($this->product->volume) {
            $message .= "🧴 Volume : {$this->product->volume}\n";
        }
        
        if ($this->product->concentration) {
            $message .= "💎 Concentration : {$this->product->concentration}\n";
        }
        
        if ($this->product->skin_type) {
            $message .= "🌟 Type de peau : {$this->product->skin_type}\n";
        }
        
        $message .= "🔗 " . request()->url() . "\n\n";
        $message .= "Pourriez-vous me donner plus d'informations sur ce produit ?";

        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/{$this->whatsappNumber}?text={$encodedMessage}";
        
        $this->dispatch('open-whatsapp', ['url' => $whatsappUrl]);
    }

    public function getIsInWishlistProperty()
    {
        if (!Auth::check()) {
            return false;
        }

        return Wishlist::where('user_id', Auth::id())
                      ->where('product_id', $this->product->id)
                      ->exists();
    }

    public function getUserHasReviewedProperty()
    {
        if (!Auth::check()) {
            return false;
        }

        return ProductReview::where('product_id', $this->product->id)
                          ->where('user_id', Auth::id())
                          ->exists();
    }

    #[On('hide-cart-success')]
    public function hideCartSuccess()
    {
        $this->showCartSuccess = false;
    }

    public function render()
    {
        return view('livewire.client.produits-id', [
            'isInWishlist' => $this->isInWishlist,
            'userHasReviewed' => $this->userHasReviewed,
        ])->layout('layout.client');
    }
}