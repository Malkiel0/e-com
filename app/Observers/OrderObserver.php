<?php

namespace App\Observers;

use App\Models\AdminNotification;
use App\Models\Order;

class OrderObserver
{

    public function creating(Order $order)
    {
        if (empty($order->number)) {
            $order->generateNumber();
        }
    }

    public function created(Order $order)
    {
        // Créer notification admin
        AdminNotification::create([
            'type' => 'new_order',
            'title' => 'Nouvelle commande',
            'message' => "Commande {$order->number} reçue ({$order->total}FCFA)",
            'icon' => '🛍️',
            'action_url' => route('admin.orders.show', $order),
            'action_text' => 'Voir',
            'data' => ['order_id' => $order->id]
        ]);
    }
    

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            AdminNotification::create([
                'type' => 'order_status_update',
                'title' => 'Mise à jour de la commande',
                'message' => "Commande {$order->number} mise à jour ({$order->status})",
                'icon' => '🛍️',
                'action_url' => route('admin.orders.show', $order),
                'action_text' => 'Voir',
                'data' => ['order_id' => $order->id]
            ]);
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        AdminNotification::create([
            'type' => 'order_deleted',
            'title' => 'Commande supprimée',
            'message' => "Commande {$order->number} supprimée",
            'icon' => '🛍️',
            'action_url' => route('admin.orders.show', $order),
            'action_text' => 'Voir',
            'data' => ['order_id' => $order->id]
        ]);
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        AdminNotification::create([
            'type' => 'order_restored',
            'title' => 'Commande restaurée',
            'message' => "Commande {$order->number} restaurée",
            'icon' => '🛍️',
            'action_url' => route('admin.orders.show', $order),
            'action_text' => 'Voir',
            'data' => ['order_id' => $order->id]
        ]);
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        AdminNotification::create([
            'type' => 'order_force_deleted',
            'title' => 'Commande supprimée définitivement',
            'message' => "Commande {$order->number} supprimée définitivement",
            'icon' => '🛍️',
            'action_url' => route('admin.orders.show', $order),
            'action_text' => 'Voir',
            'data' => ['order_id' => $order->id]
        ]);
    }
}
