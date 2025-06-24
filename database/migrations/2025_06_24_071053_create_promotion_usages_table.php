<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_usages', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('promotion_id')->constrained()->onDelete('cascade');
            $table->foreignId('promotion_code_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->decimal('discount_amount', 10, 2);
            $table->timestamp('used_at');
            
            $table->timestamps();
            
            // Index
            $table->index(['promotion_id', 'used_at']);
            $table->index(['user_id', 'promotion_id']);
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_usages');
    }
};
