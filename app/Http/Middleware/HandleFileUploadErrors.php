<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleFileUploadErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Le fichier est trop volumineux. Taille maximum autorisée: ' . ini_get('upload_max_filesize'),
                    'errors' => ['file' => ['Le fichier dépasse la taille maximum autorisée']]
                ], 413);
            }
            
            return back()->withErrors(['file' => 'Le fichier est trop volumineux.']);
        } catch (\Exception $e) {
            // Log l'erreur pour le debugging
            logger()->error('Erreur lors de l\'upload de fichier: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Erreur lors du traitement du fichier.',
                    'errors' => ['file' => ['Une erreur est survenue lors du traitement du fichier']]
                ], 500);
            }
            
            return back()->withErrors(['file' => 'Une erreur est survenue lors du traitement du fichier.']);
        }
    }
}