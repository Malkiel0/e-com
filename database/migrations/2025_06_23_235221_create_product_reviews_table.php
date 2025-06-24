<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Contenu de l'avis
            $table->integer('rating'); // 1 à 5 étoiles
            $table->string('title')->nullable();
            $table->text('comment')->nullable();
            
            // Métadonnées
            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            
            // Utilité de l'avis
            $table->integer('helpful_count')->default(0);
            $table->integer('not_helpful_count')->default(0);
            
            // Modération
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
            
            // Un utilisateur ne peut laisser qu'un avis par produit
            $table->unique(['product_id', 'user_id']);
            
            // Index
            $table->index(['product_id', 'is_approved']);
            $table->index(['user_id', 'is_approved']);
            $table->index(['rating', 'is_approved']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_reviews');
    }
};
