<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Informations de session
            $table->string('ip_address');
            $table->text('user_agent');
            $table->string('device_type')->nullable(); // mobile, desktop, tablet
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            
            // Données de navigation
            $table->string('landing_page')->nullable();
            $table->string('referrer')->nullable();
            $table->integer('page_views')->default(0);
            $table->integer('duration')->default(0); // Durée en secondes
            
            // Géolocalisation
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            
            // Conversion
            $table->boolean('has_converted')->default(false); // A effectué un achat
            $table->decimal('conversion_value', 10, 2)->nullable();
            
            // Timestamps
            $table->timestamp('started_at');
            $table->timestamp('last_activity')->nullable();
            $table->timestamp('ended_at')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['user_id', 'started_at']);
            $table->index(['started_at', 'ended_at']);
            $table->index('has_converted');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_sessions');
    }
};
