<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class LocationMismatchException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['message' => 'You are not in the correct location.'], 401);
    }
}
