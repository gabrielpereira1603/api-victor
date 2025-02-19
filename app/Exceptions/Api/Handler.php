<?php

namespace App\Exceptions\Api;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ApiException) {
            return response()->json([
                'error'   => true,
                'message' => $exception->getMessage(),
                'errors'  => $exception->getErrors(),
            ], $exception->getStatusCode());
        }

        return parent::render($request, $exception);
    }
}
