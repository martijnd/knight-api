<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserAlreadyFightingException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['message' => 'User is already in a fight.'], 301);
    }
}
