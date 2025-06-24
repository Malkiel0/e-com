<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name', 'slug', 'description', 'logo', 'website', 'country_origin',
        'is_featured', 'is_premium', 'popularity_score', 'social_links',
        'meta_data', 'is_active'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'social_links' => 'array',
        'meta_data' => 'array',
    ];

    // ========================
    // RELATIONS
    // ========================

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class)->active();
    }

    // ========================
    // MÉTHODES
    // ========================

    public function updateProductsCount()
    {
        $count = $this->activeProducts()->count();
        $this->update(['products_count' => $count]);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }

    // ========================
    // SCOPES
    // ========================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('popularity_score', 'desc');
    }
}
