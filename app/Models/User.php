<?php

namespace App\Models;

use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Laravel Breeze original (GARDÉ)
        'name',
        'email',
        'password',
        
        // Nouveaux champs e-commerce
        'first_name',
        'last_name',
        'phone',
        'birth_date',
        'gender',
        'address_line_1',
        'address_line_2',
        'city',
        'postal_code',
        'country',
        'preferences',
        'newsletter_subscribed',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'preferences' => 'array',
            'newsletter_subscribed' => 'boolean',
            'is_active' => 'boolean',
            'total_spent' => 'decimal:2',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Mutateurs pour gérer les deux systèmes
     */
    
    // Quand on définit first_name et last_name, mettre à jour 'name' automatiquement
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = $value;
        $this->updateFullName();
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = $value;
        $this->updateFullName();
    }

    // Quand on définit 'name' directement, essayer de le split
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        
        // Si first_name et last_name sont vides, essayer de split 'name'
        if (empty($this->attributes['first_name']) && empty($this->attributes['last_name'])) {
            $nameParts = explode(' ', trim($value), 2);
            $this->attributes['first_name'] = $nameParts[0] ?? '';
            $this->attributes['last_name'] = $nameParts[1] ?? '';
        }
    }

    /**
     * Accesseurs
     */
    
    // Accessor pour 'name' - utilise first_name + last_name si disponibles
    public function getNameAttribute()
    {
        // Si on a first_name et last_name, les utiliser
        if (!empty($this->first_name) || !empty($this->last_name)) {
            return trim($this->first_name . ' ' . $this->last_name);
        }
        
        // Sinon utiliser l'ancien champ 'name' s'il existe
        return $this->attributes['name'] ?? '';
    }

    // Accessor pour le nom complet (alias de name)
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    // Accessor pour l'adresse complète
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->postal_code . ' ' . $this->city,
            $this->country
        ]);
        
        return implode(', ', $parts);
    }

    // Vérifier si l'utilisateur est admin
    public function getIsAdminAttribute()
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    // URL de l'avatar
    public function getAvatarUrlAttribute()
    {
        $name = $this->name ?: $this->email;
        return "https://ui-avatars.com/api/?name=" . urlencode($name) . "&color=8B5CF6&background=F3F4F6";
    }

    /**
     * Méthodes privées
     */
    private function updateFullName()
    {
        if (isset($this->attributes['first_name']) || isset($this->attributes['last_name'])) {
            $firstName = $this->attributes['first_name'] ?? '';
            $lastName = $this->attributes['last_name'] ?? '';
            $this->attributes['name'] = trim($firstName . ' ' . $lastName);
        }
    }

    /**
     * Relations
     */
    
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    public function cartItems()
    {
        return $this->hasMany(\App\Models\CartItem::class);
    }

    public function wishlist()
    {
        return $this->hasMany(\App\Models\Wishlist::class);
    }

    public function recentlyViewed()
    {
        return $this->hasMany(\App\Models\RecentlyViewed::class);
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\ProductReview::class);
    }

    /**
     * Méthodes métier
     */
    
    public function addToCart(\App\Models\Product $product, int $quantity = 1)
    {
        return $this->cartItems()->updateOrCreate(
            ['product_id' => $product->id],
            ['quantity' => DB::raw("quantity + {$quantity}")]
        );
    }

    public function toggleWishlist(\App\Models\Product $product)
    {
        $wishlistItem = $this->wishlist()->where('product_id', $product->id)->first();
        
        if ($wishlistItem) {
            $wishlistItem->delete();
            return false;
        } else {
            $this->wishlist()->create(['product_id' => $product->id]);
            return true;
        }
    }

    public function recordProductView(\App\Models\Product $product)
    {
        $this->recentlyViewed()->where('product_id', $product->id)->delete();
        $this->recentlyViewed()->create(['product_id' => $product->id]);
        
        $recentIds = $this->recentlyViewed()
            ->orderBy('viewed_at', 'desc')
            ->limit(20)
            ->pluck('id');
            
        $this->recentlyViewed()
            ->whereNotIn('id', $recentIds)
            ->delete();
    }

    public function getCartTotal()
    {
        return $this->cartItems()
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->sum(\DB::raw('cart_items.quantity * products.price'));
    }

    public function getCartCount()
    {
        return $this->cartItems()->sum('quantity');
    }

    public function updateTotalSpent()
    {
        $total = $this->orders()
            ->whereIn('status', ['delivered', 'completed'])
            ->sum('total');
            
        $this->update(['total_spent' => $total]);
    }

    public function updateOrdersCount()
    {
        $count = $this->orders()
            ->whereIn('status', ['delivered', 'completed'])
            ->count();
            
        $this->update(['orders_count' => $count]);
    }

    /**
     * Scopes
     */
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['admin', 'super_admin']);
    }

    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeNewsletterSubscribers($query)
    {
        return $query->where('newsletter_subscribed', true);
    }
}