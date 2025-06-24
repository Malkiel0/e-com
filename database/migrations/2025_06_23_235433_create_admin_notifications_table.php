<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            
            // Type de notification
            $table->enum('type', [
                'new_order',
                'low_stock',
                'new_review',
                'new_user',
                'system_alert',
                'payment_issue'
            ]);
            
            // Contenu
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable(); // Emoji ou classe d'icône
            
            // Métadonnées
            $table->json('data')->nullable(); // Données additionnelles
            $table->string('action_url')->nullable(); // URL d'action
            $table->string('action_text')->nullable(); // Texte du bouton d'action
            
            // Destinataires
            $table->json('recipient_roles')->nullable(); // Rôles concernés
            $table->foreignId('triggered_by')->nullable()->constrained('users');
            
            // Statut
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->foreignId('read_by')->nullable()->constrained('users');
            
            // Priorité
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            
            $table->timestamps();
            
            // Index
            $table->index(['type', 'is_read']);
            $table->index(['priority', 'created_at']);
            $table->index('is_read');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_notifications');
    }
};
