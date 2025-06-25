<?php
namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class HeaderCart extends Component
{
    public $cartItems = [];
    public $cartCount = 0;
    public $cartTotal = 0;
    public $isOpen = false;
    
    // Propriétés pour les messages
    public $message = '';
    public $messageType = 'success';
    public $showMessage = false;
    
    // Propriétés WhatsApp
    public $whatsappNumber = '+2290190927406';

    public function mount()
    {
        $this->loadCartData();
    }

    public function loadCartData()
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

    public function calculateTotals()
    {
        $this->cartCount = 0;
        $this->cartTotal = 0;
        
        foreach ($this->cartItems as $item) {
            $price = $item['product']['price'] ?? 0;
            $quantity = $item['quantity'] ?? 0;
            
            $this->cartCount += $quantity;
            $this->cartTotal += $price * $quantity;
        }
    }

    public function updateQuantity($cartItemId, $newQuantity)
    {
        if ($newQuantity < 1) {
            $this->removeItem($cartItemId);
            return;
        }

        $cartItem = CartItem::find($cartItemId);
        
        if (!$cartItem) {
            $this->showMessage('Article introuvable', 'error');
            return;
        }

        // Vérifier le stock disponible
        if ($cartItem->product->track_stock && $newQuantity > $cartItem->product->stock_quantity) {
            $this->showMessage("Stock insuffisant. Maximum: {$cartItem->product->stock_quantity}", 'error');
            return;
        }

        $cartItem->update(['quantity' => $newQuantity]);
        
        $this->loadCartData();
        $this->dispatch('cart-updated');
        
        $this->showMessage('Quantité mise à jour', 'success');
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
        
        $this->loadCartData();
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

        $this->loadCartData();
        $this->dispatch('cart-updated');
        
        $this->showMessage('Panier vidé', 'info');
    }

    public function toggleCart()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function closeCart()
    {
        $this->isOpen = false;
    }

    public function openCart()
    {
        $this->isOpen = true;
    }

    public function contactWhatsApp()
    {
        if (empty($this->cartItems)) {
            $this->showMessage('Votre panier est vide', 'error');
            return;
        }

        $message = "🛍️ *Bonjour ! Voici mon panier Beauty & Fragrance :*\n\n";
        
        foreach ($this->cartItems as $item) {
            $categoryIcon = '🛍️'; // Default
            if (isset($item['product']['category']['name'])) {
                $categoryIcon = strpos(strtolower($item['product']['category']['name']), 'parfum') !== false ? '🌸' : '💄';
            }
            
            $productName = $item['product']['name'] ?? 'Produit';
            $brandName = isset($item['product']['brand']['name']) ? $item['product']['brand']['name'] : 'Marque inconnue';
            $productPrice = $item['product']['price'] ?? 0;
            $productQuantity = $item['quantity'] ?? 1;
            $itemTotal = $productPrice * $productQuantity;
            
            $message .= "{$categoryIcon} *{$productName}*\n";
            $message .= "   └ Marque: {$brandName}\n";
            $message .= "   └ Prix: {$productPrice}€ x {$productQuantity}\n";
            $message .= "   └ Sous-total: {$itemTotal}€\n\n";
        }

        $taxAmount = ($this->cartTotal * 20) / 100; // TVA 20%
        $shippingCost = $this->cartTotal >= 50 ? 0 : 5.99;
        $finalTotal = $this->cartTotal + $taxAmount + $shippingCost;

        $message .= "💰 *RÉCAPITULATIF:*\n";
        $message .= "├ Sous-total: " . number_format($this->cartTotal, 2) . "€\n";
        $message .= "├ TVA (20%): " . number_format($taxAmount, 2) . "€\n";
        
        if ($shippingCost > 0) {
            $message .= "├ Livraison: " . number_format($shippingCost, 2) . "€\n";
        } else {
            $message .= "├ Livraison: GRATUITE ✅\n";
        }
        
        $message .= "└ **TOTAL: " . number_format($finalTotal, 2) . "€**\n\n";
        $message .= "📞 J'aimerais finaliser cette commande. Merci !";

        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/{$this->whatsappNumber}?text={$encodedMessage}";
        
        $this->dispatch('open-whatsapp', ['url' => $whatsappUrl]);
        $this->closeCart();
    }

    public function goToCart()
    {
        $this->closeCart();
        return redirect()->route('panier');
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

    #[On('cart-updated')]
    public function onCartUpdated()
    {
        $this->loadCartData();
    }

    #[On('product-added-to-cart')]
    public function onProductAddedToCart()
    {
        $this->loadCartData();
        $this->openCart(); // Ouvrir le panier quand un produit est ajouté
    }

    public function getIsEmptyProperty()
    {
        return empty($this->cartItems);
    }

    public function getFreeShippingRemainingProperty()
    {
        return max(0, 50 - $this->cartTotal);
    }

    public function render()
    {
        return view('livewire.client.header-cart', [
            'isEmpty' => $this->isEmpty,
            'freeShippingRemaining' => $this->freeShippingRemaining,
        ]);
    }
}