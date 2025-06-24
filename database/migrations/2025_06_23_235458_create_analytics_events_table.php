<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            
            // Identification de l'événement
            $table->string('event_type'); // 'page_view', 'product_view', 'add_to_cart', etc.
            $table->string('event_category')->nullable();
            $table->string('event_action')->nullable();
            $table->string('event_label')->nullable();
            
            // Données utilisateur
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('session_id');
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            
            // Données contextuelles
            $table->string('url');
            $table->string('referrer')->nullable();
            $table->json('custom_data')->nullable(); // Données spécifiques
            
            // Géolocalisation
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            
            // Données de valeur
            $table->decimal('event_value', 10, 2)->nullable(); // Valeur monétaire si applicable
            
            $table->timestamps();
            
            // Index pour les requêtes d'analytics
            $table->index(['event_type', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['session_id', 'created_at']);
            $table->index('created_at'); // Pour les rapports temporels
        });
    }

    public function down()
    {
        Schema::dropIfExists('analytics_events');
    }
};
