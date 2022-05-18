<?php

namespace App\Exceptions;

use Exception;

class UserAlreadyFightingException extends Exception
{
    public function render()
    {
        return response()->json(['message' => 'User is already in a fight.'], 301);
    }
}
