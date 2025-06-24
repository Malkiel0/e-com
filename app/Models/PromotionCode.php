<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromotionCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotion_id', 'code', 'usage_count', 'usage_limit', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function usages()
    {
        return $this->hasMany(PromotionUsage::class);
    }

    public function canBeUsed()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return $this->promotion->is_valid;
    }

    public function recordUsage($order, $user = null)
    {
        $this->increment('usage_count');
        
        return $this->usages()->create([
            'promotion_id' => $this->promotion_id,
            'order_id' => $order->id,
            'user_id' => $user?->id,
            'used_at' => now(),
        ]);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
