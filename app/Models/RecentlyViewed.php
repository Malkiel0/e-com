<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentlyViewed extends Model
{
    // ✅ Spécifier le nom exact de la table
    protected $table = 'recently_viewed';

    protected $fillable = [
        'user_id', 
        'session_id', 
        'product_id', 
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}