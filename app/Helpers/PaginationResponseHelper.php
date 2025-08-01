<?php
namespace App\Helpers;
function paginationResponseHelper($code = 200, $msg = "ok" , $data = null)
{
    $response = [
        'message' => $msg,
        'data' => $data->response()->getData()->data,
        'links' => $data->response()->getData()->links,
        'meta' => $data->response()->getData()->meta
    ];
    return response()->json($response, $code);
}