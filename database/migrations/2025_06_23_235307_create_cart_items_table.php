<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable(); // Pour les utilisateurs non connectés
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            $table->integer('quantity');
            $table->timestamp('added_at')->useCurrent();
            
            // Métadonnées
            $table->json('options')->nullable(); // Options spécifiques (taille, etc.)
            
            $table->timestamps();
            
            // Un produit par utilisateur/session dans le panier
            $table->unique(['user_id', 'product_id']);
            $table->index(['session_id', 'product_id']);
            
            // Nettoyage automatique des paniers anciens
            $table->index('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
