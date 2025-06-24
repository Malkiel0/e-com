<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table users complète avec Laravel Breeze + E-commerce
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // LARAVEL BREEZE ORIGINAL (compatibilité)
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            // NOUVEAUX CHAMPS E-COMMERCE
            // Nom séparé
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            
            // Informations personnelles
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            
            // Adresses
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('France');
            
            // Préférences utilisateur
            $table->json('preferences')->nullable();
            $table->boolean('newsletter_subscribed')->default(false);
            
            // Tracking de connexion
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            
            // Métadonnées business
            $table->enum('role', ['customer', 'admin', 'super_admin'])->default('customer');
            $table->boolean('is_active')->default(true);
            $table->decimal('total_spent', 10, 2)->default(0);
            $table->integer('orders_count')->default(0);
            
            // Timestamps Laravel
            $table->timestamps();
            
            // Soft deletes pour ne jamais perdre les données clients
            $table->softDeletes();
            
            // Index pour optimiser les performances
            $table->index(['email', 'is_active']);
            $table->index(['role', 'is_active']);
            $table->index('last_login_at');
        });

        // Tables Laravel Breeze (password reset et sessions)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};