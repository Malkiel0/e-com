<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'type', 'title', 'message', 'icon', 'data', 'action_url',
        'action_text', 'recipient_roles', 'triggered_by', 'is_read',
        'read_at', 'read_by', 'priority'
    ];

    protected $casts = [
        'data' => 'array',
        'recipient_roles' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function triggeredBy()
    {
        return $this->belongsTo(User::class, 'triggered_by');
    }

    public function readBy()
    {
        return $this->belongsTo(User::class, 'read_by');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
