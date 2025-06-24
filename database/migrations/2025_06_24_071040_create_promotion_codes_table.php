<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained()->onDelete('cascade');
            
            $table->string('code')->unique();
            $table->integer('usage_count')->default(0);
            $table->integer('usage_limit')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Index
            $table->index(['code', 'is_active']);
            $table->index('promotion_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_codes');
    }
};
