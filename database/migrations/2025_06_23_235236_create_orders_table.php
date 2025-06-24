<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique(); // Numéro de commande (ex: BF-2024-001)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Informations client (dupliquées pour historique)
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->string('customer_first_name');
            $table->string('customer_last_name');
            
            // Adresse de livraison
            $table->string('shipping_address_line_1');
            $table->string('shipping_address_line_2')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_postal_code');
            $table->string('shipping_country')->default('France');
            
            // Montants
            $table->decimal('subtotal', 10, 2); // Sous-total produits
            $table->decimal('tax_amount', 10, 2)->default(0); // TVA
            $table->decimal('shipping_cost', 10, 2)->default(0); // Frais de port
            $table->decimal('discount_amount', 10, 2)->default(0); // Remises
            $table->decimal('total', 10, 2); // Total final
            
            // Statuts et suivi
            $table->enum('status', [
                'pending',      // En attente
                'confirmed',    // Confirmée
                'processing',   // En préparation
                'shipped',      // Expédiée
                'delivered',    // Livrée
                'cancelled',    // Annulée
                'refunded'      // Remboursée
            ])->default('pending');
            
            $table->enum('payment_status', [
                'pending',      // En attente
                'paid',         // Payée
                'failed',       // Échec
                'refunded'      // Remboursée
            ])->default('pending');
            
            // WhatsApp et communication
            $table->text('whatsapp_message')->nullable(); // Message WhatsApp envoyé
            $table->string('whatsapp_chat_id')->nullable(); // ID conversation WhatsApp
            $table->boolean('whatsapp_sent')->default(false);
            $table->timestamp('whatsapp_sent_at')->nullable();
            
            // Dates importantes
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->date('estimated_delivery_date')->nullable();
            
            // Tracking
            $table->string('tracking_number')->nullable();
            $table->string('carrier')->nullable(); // Transporteur
            
            // Notes et commentaires
            $table->text('customer_notes')->nullable(); // Notes du client
            $table->text('admin_notes')->nullable(); // Notes internes
            
            // Métadonnées
            $table->json('metadata')->nullable(); // Données supplémentaires
            $table->string('source')->default('website'); // Source de la commande
            $table->string('currency', 3)->default('EUR');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour optimiser les requêtes admin
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
            $table->index(['customer_email', 'status']);
            $table->index('number');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
