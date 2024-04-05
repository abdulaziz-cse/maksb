<?php

namespace App\Traits;

use App\Constants\HttpStatus;
use Illuminate\Http\JsonResponse;

trait GeneralTrait
{
    public function returnError($message, $code): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }

    public function returnSuccessMessage($message = ''): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
        ], HttpStatus::OK);
    }

    public function returnDate($value, $message): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'item' => $value,
        ], HttpStatus::OK);
    }
}
