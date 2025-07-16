<?php

// =============================================================================
// MODÈLE PROMOTION - app/Models/Promotion.php
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'type', 'value', 'minimum_amount',
        'maximum_discount', 'starts_at', 'ends_at', 'usage_limit',
        'usage_limit_per_user', 'usage_count', 'priority', 'is_active',
        'is_combinable', 'apply_to_shipping', 'conditions', 'total_savings',
        'revenue_impact', 'views_count'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'total_savings' => 'decimal:2',
        'revenue_impact' => 'decimal:2',
        'is_active' => 'boolean',
        'is_combinable' => 'boolean',
        'apply_to_shipping' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'conditions' => 'array',
    ];

    protected $appends = ['status', 'discount_text', 'usage_percentage'];

    // =========================
    // RELATIONS
    // =========================

    public function codes()
    {
        return $this->hasMany(PromotionCode::class);
    }

    public function usages()
    {
        return $this->hasMany(PromotionUsage::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'promotion_categories');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'promotion_brands');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_products');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'promotion_usages');
    }

    // =========================
    // ACCESSEURS
    // =========================

    public function getStatusAttribute()
    {
        $now = now();
        
        if (!$this->is_active) {
            return 'inactive';
        }
        
        if ($this->starts_at > $now) {
            return 'scheduled';
        }
        
        if ($this->ends_at && $this->ends_at < $now) {
            return 'expired';
        }
        
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return 'fully_used';
        }
        
        return 'active';
    }

    public function getDiscountTextAttribute()
    {
        switch ($this->type) {
            case 'percentage':
                return "{$this->value}% de réduction";
            case 'fixed_amount':
                return "{$this->value} FCFA de réduction";
            case 'free_shipping':
                return "Livraison gratuite";
            case 'buy_x_get_y':
                $buyQty = $this->conditions['buy_quantity'] ?? 1;
                $getQty = $this->conditions['get_quantity'] ?? 1;
                return "Achetez {$buyQty}, obtenez {$getQty}";
            case 'bundle':
                return "Pack à {$this->conditions['bundle_price']} FCFA";
            default:
                return "Promotion spéciale";
        }
    }

    public function getUsagePercentageAttribute()
    {
        if (!$this->usage_limit) {
            return 0;
        }
        
        return round(($this->usage_count / $this->usage_limit) * 100, 1);
    }

    public function getIsValidAttribute()
    {
        return $this->status === 'active';
    }

    public function getTimeRemainingAttribute()
    {
        if (!$this->ends_at) {
            return null;
        }
        
        $now = now();
        if ($this->ends_at <= $now) {
            return null;
        }
        
        return $this->ends_at->diffForHumans();
    }

    // =========================
    // MÉTHODES BUSINESS
    // =========================

    public function canBeUsed($user = null, $cartTotal = 0, $cartItems = [])
    {
        // Vérifier si la promotion est active
        if (!$this->is_valid) {
            return ['valid' => false, 'reason' => 'Promotion non valide'];
        }

        // Vérifier le montant minimum
        if ($this->minimum_amount && $cartTotal < $this->minimum_amount) {
            return [
                'valid' => false, 
                'reason' => "Montant minimum requis: {$this->minimum_amount}FCFA"
            ];
        }

        // Vérifier la limite globale d'utilisation
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return ['valid' => false, 'reason' => 'Promotion épuisée'];
        }

        // Vérifier la limite par utilisateur
        if ($user && $this->usage_limit_per_user) {
            $userUsages = $this->usages()->where('user_id', $user->id)->count();
            if ($userUsages >= $this->usage_limit_per_user) {
                return [
                    'valid' => false, 
                    'reason' => 'Limite d\'utilisation atteinte pour cet utilisateur'
                ];
            }
        }

        // Vérifier les restrictions de produits/catégories
        if ($this->hasRestrictions() && !$this->appliesToCart($cartItems)) {
            return [
                'valid' => false, 
                'reason' => 'Cette promotion ne s\'applique pas aux produits de votre panier'
            ];
        }

        return ['valid' => true, 'reason' => null];
    }

    public function calculateDiscount($cartTotal, $cartItems = [])
    {
        $discount = 0;

        switch ($this->type) {
            case 'percentage':
                $discount = ($cartTotal * $this->value) / 100;
                break;
                
            case 'fixed_amount':
                $discount = $this->value;
                break;
                
            case 'free_shipping':
                // À implémenter selon votre logique de frais de port
                $discount = 0; // Géré différemment
                break;
                
            case 'buy_x_get_y':
                $discount = $this->calculateBuyXGetYDiscount($cartItems);
                break;
                
            case 'bundle':
                $discount = $this->calculateBundleDiscount($cartItems);
                break;
        }

        // Appliquer la limite de réduction maximale si définie
        if ($this->maximum_discount && $discount > $this->maximum_discount) {
            $discount = $this->maximum_discount;
        }

        // S'assurer que la réduction ne dépasse pas le total
        return min($discount, $cartTotal);
    }

    private function calculateBuyXGetYDiscount($cartItems)
    {
        $buyQty = $this->conditions['buy_quantity'] ?? 1;
        $getQty = $this->conditions['get_quantity'] ?? 1;
        $discountType = $this->conditions['get_discount_type'] ?? 'percentage';
        $discountValue = $this->conditions['get_discount_value'] ?? 0;

        // Logique simplifiée - à adapter selon vos besoins
        $eligibleItems = $this->getEligibleItems($cartItems);
        $totalEligibleQty = array_sum(array_column($eligibleItems, 'quantity'));
        
        $freeItems = intval($totalEligibleQty / $buyQty) * $getQty;
        
        if ($discountType === 'free') {
            // Calculer le prix des articles gratuits (les moins chers)
            usort($eligibleItems, fn($a, $b) => $a['price'] <=> $b['price']);
            $discount = 0;
            $remainingFree = $freeItems;
            
            foreach ($eligibleItems as $item) {
                if ($remainingFree <= 0) break;
                $freeQty = min($remainingFree, $item['quantity']);
                $discount += $freeQty * $item['price'];
                $remainingFree -= $freeQty;
            }
            
            return $discount;
        }
        
        // Autres types de réduction pour buy_x_get_y
        return 0;
    }

    private function calculateBundleDiscount($cartItems)
    {
        $bundleProducts = $this->conditions['bundle_products'] ?? [];
        $bundlePrice = $this->conditions['bundle_price'] ?? 0;
        
        // Vérifier si tous les produits du bundle sont dans le panier
        $bundleComplete = true;
        $bundleTotal = 0;
        
        foreach ($bundleProducts as $productId) {
            $found = false;
            foreach ($cartItems as $item) {
                if ($item['product_id'] == $productId) {
                    $bundleTotal += $item['price'];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $bundleComplete = false;
                break;
            }
        }
        
        if ($bundleComplete && $bundleTotal > $bundlePrice) {
            return $bundleTotal - $bundlePrice;
        }
        
        return 0;
    }

    private function hasRestrictions()
    {
        return $this->categories()->exists() || 
               $this->brands()->exists() || 
               $this->products()->exists();
    }

    private function appliesToCart($cartItems)
    {
        if (!$this->hasRestrictions()) {
            return true;
        }

        foreach ($cartItems as $item) {
            if ($this->appliesToProduct($item['product_id'])) {
                return true;
            }
        }

        return false;
    }

    public function appliesToProduct($productId)
    {
        $product = Product::find($productId);
        if (!$product) return false;

        // Vérifier les produits directs
        if ($this->products()->where('product_id', $productId)->exists()) {
            return true;
        }

        // Vérifier les catégories
        if ($this->categories()->where('category_id', $product->category_id)->exists()) {
            return true;
        }

        // Vérifier les marques
        if ($this->brands()->where('brand_id', $product->brand_id)->exists()) {
            return true;
        }

        return false;
    }

    private function getEligibleItems($cartItems)
    {
        if (!$this->hasRestrictions()) {
            return $cartItems;
        }

        return array_filter($cartItems, function($item) {
            return $this->appliesToProduct($item['product_id']);
        });
    }

    public function recordUsage($order, $user = null, $discountAmount = 0)
    {
        $usage = $this->usages()->create([
            'order_id' => $order->id,
            'user_id' => $user?->id,
            'discount_amount' => $discountAmount,
            'used_at' => now(),
        ]);

        // Mettre à jour les compteurs
        $this->increment('usage_count');
        $this->increment('total_savings', $discountAmount);
        
        // Mettre à jour l'impact sur le revenu (peut être négatif si la promo augmente les ventes)
        $this->increment('revenue_impact', -$discountAmount);

        return $usage;
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    // =========================
    // SCOPES
    // =========================

    public function scopeActive($query)
    {
        $now = now();
        return $query->where('is_active', true)
                    ->where('starts_at', '<=', $now)
                    ->where(function($q) use ($now) {
                        $q->whereNull('ends_at')
                          ->orWhere('ends_at', '>', $now);
                    });
    }

    public function scopeExpired($query)
    {
        return $query->where('ends_at', '<', now());
    }

    public function scopeScheduled($query)
    {
        return $query->where('is_active', true)
                    ->where('starts_at', '>', now());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeCombinable($query)
    {
        return $query->where('is_combinable', true);
    }

    public function scopeByPriority($query, $order = 'desc')
    {
        return $query->orderBy('priority', $order);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}