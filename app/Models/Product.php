<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'sku',
        'category_id', 'brand_id', 'price', 'original_price', 'cost_price',
        'stock_quantity', 'low_stock_threshold', 'track_stock', 'stock_status',
        'weight', 'length', 'width', 'height', 'volume', 'concentration',
        'fragrance_notes', 'ingredients', 'skin_type', 'is_featured',
        'is_new', 'is_bestseller', 'is_limited_edition', 'available_from',
        'available_until', 'meta_title', 'meta_description', 'meta_keywords',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'fragrance_notes' => 'array',
        'ingredients' => 'array',
        'meta_keywords' => 'array',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_limited_edition' => 'boolean',
        'track_stock' => 'boolean',
        'available_from' => 'date',
        'available_until' => 'date',
        'rating_average' => 'decimal:1',
    ];

    protected $appends = ['image_url', 'is_in_stock', 'discount_percentage', 'final_price'];

    // ========================
    // RELATIONS
    // ========================

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->approved();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function recentlyViewed()
    {
        return $this->hasMany(RecentlyViewed::class);
    }

    // ========================
    // ACCESSEURS
    // ========================

    public function getImageUrlAttribute()
    {
        $primaryImage = $this->primaryImage;
        return $primaryImage ? Storage::url($primaryImage->file_path) : '/images/product-placeholder.jpg';
    }

    public function getIsInStockAttribute()
    {
        if (!$this->track_stock) return true;
        return $this->stock_quantity > 0 && $this->stock_status === 'in_stock';
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->original_price || $this->original_price <= $this->price) {
            return 0;
        }
        
        return round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    public function getFinalPriceAttribute()
    {
        return $this->price; // Peut être étendu pour les promotions
    }

    public function getIsLowStockAttribute()
    {
        return $this->track_stock && $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function getUrlAttribute()
    {
        return route('product.show', $this->slug);
    }

    // ========================
    // MÉTHODES BUSINESS
    // ========================

    public function decreaseStock(int $quantity)
    {
        if (!$this->track_stock) return true;
        
        if ($this->stock_quantity < $quantity) {
            throw new \Exception("Stock insuffisant pour le produit {$this->name}");
        }
        
        $this->decrement('stock_quantity', $quantity);
        
        // Mettre à jour le statut si nécessaire
        if ($this->stock_quantity <= 0) {
            $this->update(['stock_status' => 'out_of_stock']);
        }
        
        return true;
    }

    public function increaseStock(int $quantity)
    {
        $this->increment('stock_quantity', $quantity);
        
        // Remettre en stock si nécessaire
        if ($this->stock_status === 'out_of_stock' && $this->stock_quantity > 0) {
            $this->update(['stock_status' => 'in_stock']);
        }
        
        return true;
    }

    public function updateRating()
    {
        $reviews = $this->approvedReviews();
        
        $average = $reviews->avg('rating') ?: 0;
        $count = $reviews->count();
        
        $this->update([
            'rating_average' => round($average, 1),
            'reviews_count' => $count
        ]);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementSales(int $quantity = 1)
    {
        $this->increment('sales_count', $quantity);
    }

    public function addToWishlist(User $user)
    {
        if (!$this->wishlists()->where('user_id', $user->id)->exists()) {
            $this->wishlists()->create(['user_id' => $user->id]);
            $this->increment('wishlist_count');
        }
    }

    public function removeFromWishlist(User $user)
    {
        if ($this->wishlists()->where('user_id', $user->id)->delete()) {
            $this->decrement('wishlist_count');
        }
    }

    // ========================
    // SCOPES
    // ========================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->where(function($q) {
            $q->where('track_stock', false)
              ->orWhere(function($sq) {
                  $sq->where('track_stock', true)
                     ->where('stock_quantity', '>', 0)
                     ->where('stock_status', 'in_stock');
              });
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('original_price')
                    ->whereColumn('price', '<', 'original_price');
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%")
              ->orWhere('short_description', 'LIKE', "%{$term}%")
              ->orWhereHas('brand', function($brandQuery) use ($term) {
                  $brandQuery->where('name', 'LIKE', "%{$term}%");
              });
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
