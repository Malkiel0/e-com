<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            
            // Informations de base
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Type et valeur
            $table->enum('type', ['percentage', 'fixed_amount', 'free_shipping', 'buy_x_get_y', 'bundle']);
            $table->decimal('value', 10, 2);
            
            // Conditions
            $table->decimal('minimum_amount', 10, 2)->nullable();
            $table->decimal('maximum_discount', 10, 2)->nullable();
            
            // Dates de validité
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            
            // Limites d'utilisation
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_limit_per_user')->nullable();
            $table->integer('usage_count')->default(0);
            
            // Paramètres
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_combinable')->default(false);
            $table->boolean('apply_to_shipping')->default(false);
            
            // Conditions spécifiques (JSON)
            $table->json('conditions')->nullable();
            
            // Statistiques
            $table->decimal('total_savings', 12, 2)->default(0);
            $table->decimal('revenue_impact', 12, 2)->default(0);
            $table->integer('views_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['is_active', 'starts_at', 'ends_at']);
            $table->index(['type', 'is_active']);
            $table->index('priority');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
