<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function successResponse(array $data, int $httpCode = 200)
    {
        $response = [
            'status' => 'succeed',
            'message' => 'Permintaan berhasil diproses',
            'data' => $data
        ];
        return response()->json($response, $httpCode);
    }

    protected function failResponse(array $data, int $httpCode)
    {
        $response = [
            'status' => 'failed',
            'message' => 'Permintaan gagal diproses',
            'data' => $data
        ];
        return response()->json($response, $httpCode);
    }
}
