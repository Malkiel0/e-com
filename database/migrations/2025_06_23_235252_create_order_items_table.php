<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Données produit au moment de la commande (historique)
            $table->string('product_name'); // Nom au moment de l'achat
            $table->string('product_sku');
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable(); // Image principale
            
            // Prix et quantité
            $table->decimal('unit_price', 10, 2); // Prix unitaire au moment de l'achat
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2); // Prix total de la ligne
            
            // Métadonnées
            $table->json('product_metadata')->nullable(); // Caractéristiques du produit
            
            $table->timestamps();
            
            // Index
            $table->index(['order_id', 'product_id']);
            $table->index('product_id'); // Pour les statistiques produit
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
