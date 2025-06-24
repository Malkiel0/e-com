<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('country_origin')->nullable();
            
            // Marketing
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->integer('popularity_score')->default(0); // Pour le tri
            
            // Métadonnées
            $table->json('social_links')->nullable(); // Instagram, etc.
            $table->json('meta_data')->nullable();
            
            // Statut
            $table->boolean('is_active')->default(true);
            
            // Compteurs
            $table->integer('products_count')->default(0);
            
            $table->timestamps();
            
            // Index
            $table->index(['is_active', 'is_featured']);
            $table->index('popularity_score');
        });
    }

    public function down()
    {
        Schema::dropIfExists('brands');
    }
};
