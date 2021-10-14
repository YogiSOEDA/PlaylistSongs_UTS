<?php

namespace App\Exceptions;

class PbeNotAuthenticatedException extends \Exception
{
    public function render()
    {
        return response()->json([
            'status' => 'failed',
            'message' => 'Anda tidak terauntentikasi'
        ], 401);
    }
}
