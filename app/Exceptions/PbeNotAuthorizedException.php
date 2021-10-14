<?php

namespace App\Exceptions;

class PbeNotAuthorizedException extends \Exception
{
    public function render()
    {
        return response()->json([
            'status' => 'failed',
            'message' => 'Anda tidak memiliki hak akses ke halaman ini'
        ], 403);
    }
}
