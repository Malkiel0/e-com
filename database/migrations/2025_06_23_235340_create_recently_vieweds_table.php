<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recently_viewed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable(); // Pour visiteurs non connectés
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            $table->timestamp('viewed_at')->useCurrent();
            
            $table->timestamps();
            
            // Index pour requêtes efficaces
            $table->index(['user_id', 'viewed_at']);
            $table->index(['session_id', 'viewed_at']);
            $table->index('viewed_at'); // Pour nettoyage automatique
        });
    }

    public function down()
    {
        Schema::dropIfExists('recently_viewed');
    }
};
