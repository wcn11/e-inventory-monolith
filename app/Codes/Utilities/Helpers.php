<?php

function successResponse($data = null, $httpCode = 200): \Illuminate\Http\JsonResponse
{

    return response()->json([

        "success" => true,

        "data" => $data

    ],
        $httpCode);

}

function errorResponse($message = null, $httpCode = 404): \Illuminate\Http\JsonResponse
{

    return response()->json([

        "success" => false,

        "message" => $message,

    ], $httpCode);

}
