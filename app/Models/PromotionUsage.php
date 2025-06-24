<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromotionUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotion_id', 'promotion_code_id', 'order_id', 'user_id', 
        'discount_amount', 'used_at'
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'used_at' => 'datetime',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function promotionCode()
    {
        return $this->belongsTo(PromotionCode::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
