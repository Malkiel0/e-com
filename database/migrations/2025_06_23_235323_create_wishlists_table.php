<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            
            // Un produit par utilisateur dans la wishlist
            $table->unique(['user_id', 'product_id']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
};
