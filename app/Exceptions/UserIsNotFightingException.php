<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserIsNotFightingException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'User is currently not fighting.',
        ], 401);
    }
}
