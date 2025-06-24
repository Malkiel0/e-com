<?php
namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Panier extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $taxRate = 20; // TVA 20%
    public $taxAmount = 0;
    public $shippingCost = 0;
    public $freeShippingThreshold = 50;
    public $total = 0;
    
    // Propriétés pour les messages
    public $message = '';
    public $messageType = 'success'; // success, error, info
    public $showMessage = false;
    
    // Propriétés WhatsApp
    public $whatsappNumber = '+33123456789';
    
    // Propriétés pour les animations
    public $updatingQuantities = [];
    
    // Propriétés pour les recommandations
    public $recommendedProducts = [];

    public function mount()
    {
        $this->loadCartItems();
        $this->loadRecommendedProducts();
    }

    public function loadCartItems()
    {
        if (Auth::check()) {
            $this->cartItems = CartItem::with(['product.brand', 'product.category', 'product.images'])
                                     ->where('user_id', Auth::id())
                                     ->get()
                                     ->toArray();
        } else {
            $sessionId = session()->getId();
            $this->cartItems = CartItem::with(['product.brand', 'product.category', 'product.images'])
                                     ->where('session_id', $sessionId)
                                     ->get()
                                     ->toArray();
        }

        $this->calculateTotals();
    }

    public function loadRecommendedProducts()
    {
        // Récupérer des produits recommandés basés sur le panier
        $categoryIds = [];
        foreach ($this->cartItems as $item) {
            if (isset($item['product']['category_id'])) {
                $categoryIds[] = $item['product']['category_id'];
            }
        }

        if (!empty($categoryIds)) {
            $this->recommendedProducts = Product::with(['brand', 'category', 'images'])
                                               ->whereIn('category_id', array_unique($categoryIds))
                                               ->whereNotIn('id', array_column($this->cartItems, 'product_id'))
                                               ->active()
                                               ->inStock()
                                               ->featured()
                                               ->limit(4)
                                               ->get()
                                               ->toArray();
        } else {
            // Si le panier est vide, afficher les produits populaires
            $this->recommendedProducts = Product::with(['brand', 'category', 'images'])
                                               ->active()
                                               ->inStock()
                                               ->orderBy('sales_count', 'desc')
                                               ->limit(4)
                                               ->get()
                                               ->toArray();
        }
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        
        foreach ($this->cartItems as $item) {
            $price = $item['product']['price'] ?? 0;
            $quantity = $item['quantity'] ?? 0;
            $this->subtotal += $price * $quantity;
        }

        // Calcul de la TVA
        $this->taxAmount = ($this->subtotal * $this->taxRate) / 100;

        // Calcul des frais de livraison
        if ($this->subtotal >= $this->freeShippingThreshold) {
            $this->shippingCost = 0;
        } else {
            $this->shippingCost = 5.99; // Frais de livraison standard
        }

        // Total final
        $this->total = $this->subtotal + $this->taxAmount + $this->shippingCost;
    }

    public function updateQuantity($cartItemId, $newQuantity)
    {
        if ($newQuantity < 1) {
            return;
        }

        // Ajouter l'item à la liste des mises à jour pour l'animation
        $this->updatingQuantities[] = $cartItemId;

        $cartItem = CartItem::find($cartItemId);
        
        if (!$cartItem) {
            $this->showMessage('Article introuvable dans le panier', 'error');
            return;
        }

        // Vérifier le stock disponible
        if ($cartItem->product->track_stock && $newQuantity > $cartItem->product->stock_quantity) {
            $this->showMessage("Stock insuffisant. Maximum disponible: {$cartItem->product->stock_quantity}", 'error');
            return;
        }

        $cartItem->update(['quantity' => $newQuantity]);
        
        $this->loadCartItems();
        $this->dispatch('cart-updated');
        
        $this->showMessage('Quantité mise à jour', 'success');
        
        // Retirer l'item de la liste des mises à jour après animation
        $this->dispatch('quantity-updated', ['itemId' => $cartItemId]);
    }

    public function removeItem($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        
        if (!$cartItem) {
            $this->showMessage('Article introuvable', 'error');
            return;
        }

        $productName = $cartItem->product->name;
        $cartItem->delete();
        
        $this->loadCartItems();
        $this->loadRecommendedProducts();
        $this->dispatch('cart-updated');
        
        $this->showMessage("« {$productName} » retiré du panier", 'success');
    }

    public function clearCart()
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            $sessionId = session()->getId();
            CartItem::where('session_id', $sessionId)->delete();
        }

        $this->loadCartItems();
        $this->loadRecommendedProducts();
        $this->dispatch('cart-updated');
        
        $this->showMessage('Panier vidé', 'info');
    }

    public function addRecommendedToCart($productId)
    {
        $product = Product::find($productId);
        
        if (!$product || !$product->is_in_stock) {
            $this->showMessage('Produit indisponible', 'error');
            return;
        }

        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                              ->where('product_id', $productId)
                              ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => 1,
                ]);
            }
        } else {
            $sessionId = session()->getId();
            $cartItem = CartItem::where('session_id', $sessionId)
                              ->where('product_id', $productId)
                              ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                CartItem::create([
                    'session_id' => $sessionId,
                    'product_id' => $productId,
                    'quantity' => 1,
                ]);
            }
        }

        $this->loadCartItems();
        $this->loadRecommendedProducts();
        $this->dispatch('cart-updated');
        
        $categoryIcon = '💄'; // Default icon
        if ($product->category && strpos(strtolower($product->category->name), 'parfum') !== false) {
            $categoryIcon = '🌸';
        }
        
        $this->showMessage("{$categoryIcon} {$product->name} ajouté au panier !", 'success');
    }

    public function contactWhatsApp()
    {
        if (empty($this->cartItems)) {
            $this->showMessage('Votre panier est vide', 'error');
            return;
        }

        $message = "🛍️ *Bonjour ! Voici mon panier Beauty & Fragrance :*\n\n";
        
        foreach ($this->cartItems as $item) {
            $categoryIcon = '🛍️'; // Default icon
            if (isset($item['product']['category']['name'])) {
                $categoryIcon = strpos(strtolower($item['product']['category']['name']), 'parfum') !== false ? '🌸' : '💄';
            }
            
            $itemTotal = ($item['product']['price'] ?? 0) * ($item['quantity'] ?? 1);
            $productName = $item['product']['name'] ?? 'Produit';
            $brandName = isset($item['product']['brand']['name']) ? $item['product']['brand']['name'] : 'Marque inconnue';
            $productPrice = $item['product']['price'] ?? 0;
            $productQuantity = $item['quantity'] ?? 1;
            
            $message .= "{$categoryIcon} *{$productName}*\n";
            $message .= "   └ Marque: {$brandName}\n";
            $message .= "   └ Prix unitaire: {$productPrice}€\n";
            $message .= "   └ Quantité: {$productQuantity}\n";
            $message .= "   └ Sous-total: {$itemTotal}€\n\n";
        }

        $message .= "💰 *RÉCAPITULATIF:*\n";
        $message .= "├ Sous-total: " . number_format($this->subtotal, 2) . "€\n";
        $message .= "├ TVA (20%): " . number_format($this->taxAmount, 2) . "€\n";
        
        if ($this->shippingCost > 0) {
            $message .= "├ Livraison: " . number_format($this->shippingCost, 2) . "€\n";
        } else {
            $message .= "├ Livraison: GRATUITE ✅\n";
        }
        
        $message .= "└ **TOTAL: " . number_format($this->total, 2) . "€**\n\n";
        
        $message .= "📍 *Informations de livraison à discuter*\n";
        $message .= "💳 *Mode de paiement à convenir*\n\n";
        $message .= "Merci de me confirmer la disponibilité et le délai de livraison ! 😊";

        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/{$this->whatsappNumber}?text={$encodedMessage}";
        
        $this->dispatch('open-whatsapp', ['url' => $whatsappUrl]);
    }

    public function showMessage($text, $type = 'success')
    {
        $this->message = $text;
        $this->messageType = $type;
        $this->showMessage = true;
        
        $this->dispatch('hide-message');
    }

    #[On('hide-message')]
    public function hideMessage()
    {
        $this->showMessage = false;
    }

    #[On('quantity-updated')]
    public function onQuantityUpdated($data)
    {
        $this->updatingQuantities = array_filter($this->updatingQuantities, function($id) use ($data) {
            return $id !== $data['itemId'];
        });
    }

    public function getCartCountProperty()
    {
        $total = 0;
        foreach ($this->cartItems as $item) {
            $total += $item['quantity'] ?? 0;
        }
        return $total;
    }

    public function getIsCartEmptyProperty()
    {
        return empty($this->cartItems);
    }

    public function getSavingsProperty()
    {
        return max(0, $this->freeShippingThreshold - $this->subtotal);
    }

    public function render()
    {
        return view('livewire.client.panier', [
            'cartCount' => $this->cartCount,
            'isCartEmpty' => $this->isCartEmpty,
            'savings' => $this->savings,
        ])->layout('layout.client');
    }
}