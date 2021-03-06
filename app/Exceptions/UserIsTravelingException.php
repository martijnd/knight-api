<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserIsTravelingException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => 'User is currently traveling',
        ], 401);
    }
}
