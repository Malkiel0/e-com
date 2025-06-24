<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            
            // Préférences
            $table->json('interests')->nullable(); // Parfums, beauté, etc.
            $table->json('preferences')->nullable(); // Fréquence, etc.
            
            // Statut
            $table->boolean('is_active')->default(true);
            $table->timestamp('subscribed_at')->useCurrent();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamp('last_email_sent')->nullable();
            
            // Tracking
            $table->string('source')->nullable(); // Comment ils se sont inscrits
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            // Token pour désabonnement
            $table->string('unsubscribe_token')->unique();
            
            $table->timestamps();
            
            // Index
            $table->index(['is_active', 'subscribed_at']);
            $table->index('email');
        });
    }

    public function down()
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
};
