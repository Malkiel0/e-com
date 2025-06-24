<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // Qui a fait l'action
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Quelle action
            $table->string('action'); // 'created', 'updated', 'deleted', etc.
            $table->string('entity_type'); // 'Product', 'Order', etc.
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('entity_name')->nullable(); // Nom de l'entité affectée
            
            // Détails de l'action
            $table->text('description');
            $table->json('old_values')->nullable(); // Anciennes valeurs
            $table->json('new_values')->nullable(); // Nouvelles valeurs
            
            // Contexte
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['user_id', 'created_at']);
            $table->index(['entity_type', 'entity_id']);
            $table->index(['action', 'created_at']);
            $table->index('created_at'); // Pour nettoyage automatique
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
