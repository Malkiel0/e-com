<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_backups', function (Blueprint $table) {
            $table->id();
            
            // Informations de sauvegarde
            $table->string('name'); // Nom de la sauvegarde
            $table->string('type'); // 'database', 'files', 'complete'
            $table->string('file_path'); // Chemin du fichier de sauvegarde
            $table->bigInteger('file_size'); // Taille en bytes
            
            // Métadonnées
            $table->json('metadata')->nullable(); // Tables sauvegardées, etc.
            $table->text('description')->nullable();
            
            // Statut
            $table->enum('status', ['in_progress', 'completed', 'failed'])->default('in_progress');
            $table->text('error_message')->nullable();
            
            // Qui a créé la sauvegarde
            $table->foreignId('created_by')->constrained('users');
            
            // Timestamps
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['type', 'status']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_backups');
    }
};
