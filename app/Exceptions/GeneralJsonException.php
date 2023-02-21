<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeneralJsonException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report(): void
    {

    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return new JsonResponse([
            'errors' => [
                'message' => $this->getMessage(),
            ],
        ], $this->code);
    }
}
