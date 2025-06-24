<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Informations de base
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('sku')->unique(); // Code produit
            
            // Relations
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            
            // Prix
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable(); // Prix barré
            $table->decimal('cost_price', 10, 2)->nullable(); // Prix d'achat
            
            // Stock
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->boolean('track_stock')->default(true);
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'on_backorder'])->default('in_stock');
            
            // Dimensions et poids (pour livraison)
            $table->decimal('weight', 8, 2)->nullable(); // en grammes
            $table->decimal('length', 8, 2)->nullable(); // en cm
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            
            // Spécifiques beauté/parfum
            $table->string('volume')->nullable(); // "50ml", "100ml"
            $table->string('concentration')->nullable(); // "Eau de Parfum", "Eau de Toilette"
            $table->json('fragrance_notes')->nullable(); // Notes olfactives
            $table->json('ingredients')->nullable(); // Liste ingrédients
            $table->string('skin_type')->nullable(); // Pour produits beauté
            
            // Marketing et statuts
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_limited_edition')->default(false);
            $table->date('available_from')->nullable();
            $table->date('available_until')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            
            // Évaluations
            $table->decimal('rating_average', 2, 1)->default(0);
            $table->integer('reviews_count')->default(0);
            
            // Compteurs de performance
            $table->integer('views_count')->default(0);
            $table->integer('sales_count')->default(0);
            $table->integer('wishlist_count')->default(0);
            
            // Statut
            $table->enum('status', ['draft', 'active', 'inactive', 'archived'])->default('draft');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index optimisés pour les requêtes fréquentes
            $table->index(['status', 'is_featured']);
            $table->index(['category_id', 'status']);
            $table->index(['brand_id', 'status']);
            $table->index(['price', 'status']);
            $table->index(['stock_status', 'status']);
            $table->index(['rating_average', 'status']);
            $table->index('created_at');
            $table->fullText(['name', 'description', 'short_description']); // Recherche
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
