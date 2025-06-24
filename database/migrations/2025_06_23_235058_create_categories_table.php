<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable(); // Pour les emojis comme 🌸, 💄
            $table->string('color', 7)->default('#8B5CF6'); // Couleur hex
            $table->json('meta_data')->nullable(); // SEO et données supplémentaires
            
            // Hiérarchie
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('sort_order')->default(0);
            
            // Statut
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            
            // Compteurs dénormalisés pour performance
            $table->integer('products_count')->default(0);
            
            $table->timestamps();
            
            // Relations et index
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
            $table->index(['is_active', 'sort_order']);
            $table->index('parent_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
