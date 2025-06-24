<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Clé du paramètre
            $table->text('value')->nullable(); // Valeur (JSON si nécessaire)
            $table->string('type')->default('string'); // Type de donnée
            $table->string('group')->default('general'); // Groupe de paramètres
            $table->text('description')->nullable();
            
            // Métadonnées
            $table->boolean('is_public')->default(false); // Accessible côté client
            $table->boolean('is_encrypted')->default(false); // Valeur cryptée
            
            $table->timestamps();
            
            // Index
            $table->index(['group', 'key']);
            $table->index('is_public');
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
