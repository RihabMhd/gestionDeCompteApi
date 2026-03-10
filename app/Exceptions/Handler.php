<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException; // INDISPENSABLE
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Les champs qui ne doivent pas être flashés dans la session.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Enregistre les rappels de gestion des exceptions.
     */
    public function register(): void
    {
        // On garde une seule méthode register
        $this->reportable(function (Throwable $e) {
            //
        });

        // Gestion personnalisée pour l'API
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
        });
    }
}