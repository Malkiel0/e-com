<?php

namespace App\Models;

use DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $fillable = [
        'number', 'user_id', 'customer_email', 'customer_phone',
        'customer_first_name', 'customer_last_name', 'shipping_address_line_1',
        'shipping_address_line_2', 'shipping_city', 'shipping_postal_code',
        'shipping_country', 'subtotal', 'tax_amount', 'shipping_cost',
        'discount_amount', 'total', 'status', 'payment_status',
        'whatsapp_message', 'whatsapp_chat_id', 'whatsapp_sent',
        'whatsapp_sent_at', 'confirmed_at', 'shipped_at', 'delivered_at',
        'estimated_delivery_date', 'tracking_number', 'carrier',
        'customer_notes', 'admin_notes', 'metadata', 'source', 'currency'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'whatsapp_sent' => 'boolean',
        'whatsapp_sent_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'estimated_delivery_date' => 'date',
        'metadata' => 'array',
    ];

    protected $appends = ['full_shipping_address', 'customer_full_name'];

    // ========================
    // RELATIONS
    // ========================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function couponUsage()
    {
        return $this->hasOne(CouponUsage::class);
    }

    // ========================
    // ACCESSEURS
    // ========================

    public function getFullShippingAddressAttribute()
    {
        $parts = array_filter([
            $this->shipping_address_line_1,
            $this->shipping_address_line_2,
            $this->shipping_postal_code . ' ' . $this->shipping_city,
            $this->shipping_country
        ]);
        
        return implode(', ', $parts);
    }

    public function getCustomerFullNameAttribute()
    {
        return "{$this->customer_first_name} {$this->customer_last_name}";
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'processing' => 'En préparation',
            'shipped' => 'Expédiée',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée',
            'refunded' => 'Remboursée',
            default => 'Inconnu'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'processing' => 'indigo',
            'shipped' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            'refunded' => 'gray',
            default => 'gray'
        };
    }

    // ========================
    // MÉTHODES BUSINESS
    // ========================

    public function generateNumber()
    {
        $year = date('Y');
        $lastOrder = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
            
        $sequence = $lastOrder ? 
            (int) substr($lastOrder->number, -3) + 1 : 1;
            
        $this->number = "BF-{$year}-" . str_pad($sequence, 3, '0', STR_PAD_LEFT);
        $this->save();
    }

    public function updateStatus($newStatus, $notes = null)
    {
        $oldStatus = $this->status;
        
        $this->update([
            'status' => $newStatus,
            'admin_notes' => $notes
        ]);
        
        // Mettre à jour les timestamps selon le statut
        switch ($newStatus) {
            case 'confirmed':
                $this->update(['confirmed_at' => now()]);
                break;
            case 'shipped':
                $this->update(['shipped_at' => now()]);
                break;
            case 'delivered':
                $this->update(['delivered_at' => now()]);
                // Mettre à jour les statistiques utilisateur
                if ($this->user) {
                    $this->user->updateTotalSpent();
                    $this->user->updateOrdersCount();
                }
                break;
        }
        
        // Créer une notification admin
        AdminNotification::create([
            'type' => 'order_status_changed',
            'title' => "Commande {$this->number} mise à jour",
            'message' => "Statut changé de {$oldStatus} à {$newStatus}",
            'data' => ['order_id' => $this->id, 'old_status' => $oldStatus, 'new_status' => $newStatus]
        ]);
    }

    public function calculateTotals()
    {
        $subtotal = $this->items()->sum(DB::raw('quantity * unit_price'));
        $taxAmount = $subtotal * (config('shop.tax_rate', 0.20) / 100);
        
        $total = $subtotal + $taxAmount + $this->shipping_cost - $this->discount_amount;
        
        $this->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total
        ]);
    }

    public function generateWhatsAppMessage()
    {
        $message = "🛍️ *Nouvelle commande Beauty & Fragrance*\n\n";
        $message .= "📋 **Commande:** {$this->number}\n";
        $message .= "👤 **Client:** {$this->customer_full_name}\n";
        $message .= "📧 **Email:** {$this->customer_email}\n";
        if ($this->customer_phone) {
            $message .= "📱 **Téléphone:** {$this->customer_phone}\n";
        }
        $message .= "\n**📦 Produits commandés:**\n";
        
        foreach ($this->items as $item) {
            $message .= "• {$item->product_name} (x{$item->quantity}) - {$item->total_price}FCFA\n";
        }
        
        $message .= "\n💰 **Total:** {$this->total}FCFA\n";
        $message .= "🚚 **Adresse de livraison:**\n{$this->full_shipping_address}\n\n";
        
        if ($this->customer_notes) {
            $message .= "📝 **Notes client:** {$this->customer_notes}\n\n";
        }
        
        $message .= "✨ Merci pour votre commande !";
        
        return $message;
    }

    // ========================
    // SCOPES
    // ========================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['delivered']);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    public function scopeWhatsAppNotSent($query)
    {
        return $query->where('whatsapp_sent', false)
                    ->whereIn('status', ['pending', 'confirmed']);
    }
}
