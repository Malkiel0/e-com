<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            $table->string('original_name'); // Nom original du fichier
            $table->string('file_name'); // Nom stocké
            $table->string('file_path'); // Chemin complet
            $table->string('mime_type');
            $table->integer('file_size'); // en bytes
            
            // Métadonnées image
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('alt_text')->nullable();
            
            // Variations (thumbnails, etc.)
            $table->json('variations')->nullable(); // URLs des différentes tailles
            
            // Organisation
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false); // Image principale
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Index
            $table->index(['product_id', 'is_primary']);
            $table->index(['product_id', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
};
