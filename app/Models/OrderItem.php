<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'product_sku',
        'product_description', 'product_image', 'unit_price',
        'quantity', 'total_price', 'product_metadata'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'product_metadata' => 'array',
    ];

    // ========================
    // RELATIONS
    // ========================

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ========================
    // MÉTHODES
    // ========================

    public function calculateTotal()
    {
        $this->total_price = $this->unit_price * $this->quantity;
        $this->save();
    }
}
