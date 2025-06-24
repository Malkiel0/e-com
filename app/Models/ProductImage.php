<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id', 'original_name', 'file_name', 'file_path',
        'mime_type', 'file_size', 'width', 'height', 'alt_text',
        'variations', 'sort_order', 'is_primary', 'is_active'
    ];

    protected $casts = [
        'variations' => 'array',
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }
}
