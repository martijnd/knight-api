<?php

namespace App\Exceptions;

use Exception;

class LocationMismatchException extends Exception
{
    public function render()
    {
        return response()->json(['message' => 'You are not in the correct location.'], 401);
    }
}
