<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UsernameAlreadyTakenException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['message' => 'Username already taken.'], 409);
    }
}
