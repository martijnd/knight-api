<?php

namespace App\Exceptions;

use Exception;

class UsernameAlreadyTakenException extends Exception
{
    public function render()
    {
        return response()->json(['message' => 'Username already taken.'], 401);
    }
}
