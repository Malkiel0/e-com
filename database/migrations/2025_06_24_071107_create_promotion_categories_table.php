<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['promotion_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_categories');
    }
};
