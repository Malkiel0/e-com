<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanupTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:temp-files {--force : Force cleanup without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nettoie les fichiers temporaires Livewire anciens';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🧹 Nettoyage des fichiers temporaires...');

        try {
            $tempPath = 'livewire-tmp';
            $disk = Storage::disk('local');
            
            if (!$disk->exists($tempPath)) {
                $this->info('Aucun fichier temporaire trouvé.');
                return 0;
            }

            $files = $disk->allFiles($tempPath);
            $deletedCount = 0;
            $hoursOld = 2; // Supprimer les fichiers de plus de 2 heures

            foreach ($files as $file) {
                $lastModified = $disk->lastModified($file);
                $fileAge = Carbon::createFromTimestamp($lastModified);
                
                if ($fileAge->diffInHours(now()) > $hoursOld) {
                    $disk->delete($file);
                    $deletedCount++;
                }
            }

            if ($deletedCount > 0) {
                $this->info("✅ {$deletedCount} fichier(s) temporaire(s) supprimé(s).");
            } else {
                $this->info('✅ Aucun fichier temporaire à supprimer.');
            }

            // Nettoyer aussi les dossiers vides
            $directories = $disk->allDirectories($tempPath);
            $deletedDirs = 0;
            
            foreach (array_reverse($directories) as $dir) {
                if (empty($disk->allFiles($dir)) && empty($disk->allDirectories($dir))) {
                    $disk->deleteDirectory($dir);
                    $deletedDirs++;
                }
            }

            if ($deletedDirs > 0) {
                $this->info("✅ {$deletedDirs} dossier(s) vide(s) supprimé(s).");
            }

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Erreur lors du nettoyage: ' . $e->getMessage());
            return 1;
        }
    }
}