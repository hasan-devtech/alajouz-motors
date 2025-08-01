<?php
namespace App\Helpers;

function sendResponseHelper($code = 200, $msg = 'ok', $data = null)
{
    $response = [
        'message' => $msg,
        'data' => $data,
    ];

    return response()->json($response, $code);
}