<?php

namespace App\Exceptions;

use App\Exceptions\General\FileExistException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthorizationException) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
        if ($e instanceof FileNotFoundException) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
        if ($e instanceof FileExistException) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
        if ($e instanceof ModelNotFoundException) {
            return resourceNotFoundJsonResponse();
        }

        return parent::render($request, $e); 
    }
}
