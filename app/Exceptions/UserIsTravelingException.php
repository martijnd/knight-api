<?php

namespace App\Exceptions;

use Exception;

class UserIsTravelingException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'User is currently traveling',
        ], 401);
    }
}
