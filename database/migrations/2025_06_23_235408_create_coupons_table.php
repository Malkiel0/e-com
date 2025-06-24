<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name'); // Nom de la promotion
            $table->text('description')->nullable();
            
            // Type de réduction
            $table->enum('type', ['percentage', 'fixed_amount', 'free_shipping']);
            $table->decimal('value', 10, 2); // Valeur de la réduction
            
            // Conditions d'utilisation
            $table->decimal('minimum_amount', 10, 2)->nullable(); // Montant minimum
            $table->integer('usage_limit')->nullable(); // Limite d'utilisation globale
            $table->integer('usage_limit_per_user')->nullable(); // Limite par utilisateur
            $table->integer('used_count')->default(0); // Nombre d'utilisations
            
            // Restrictions produits/catégories
            $table->json('applicable_categories')->nullable();
            $table->json('applicable_products')->nullable();
            $table->json('excluded_categories')->nullable();
            $table->json('excluded_products')->nullable();
            
            // Dates de validité
            $table->timestamp('starts_at');
            $table->timestamp('expires_at')->nullable();
            
            // Statut
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Index
            $table->index(['code', 'is_active']);
            $table->index(['starts_at', 'expires_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
