<?php

declare(strict_types=1);

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait ApiResponseTrait
{
    public function responseWithData(array|string $data, int $code): JsonResponse
    {
        return response()->json([
            "data" => $data,
        ], $code);
    }

    public function responseWithoutData($data, int $code): JsonResponse
    {
        return response()->json(
            $data,
            $code
        );
    }

    public function responseErrorByException(Exception|Throwable $exception, int $code = Response::HTTP_FORBIDDEN): JsonResponse
    {
        $message = 'En este momento no puede procesarse su solicitud, intente de nuevo más tarde.';
        if (!empty($exception->getMessage())) {
            $message = $exception->getMessage();
        }
        $code = $code === 0 || is_null($code) ? Response::HTTP_FORBIDDEN : $code;

        Log::error("Fail - Message: {$exception->getMessage()}, File: {$exception->getFile()}, Line: {$exception->getLine()}");

        return response()->json([
            "message" => $message
        ], $code === 0 ? Response::HTTP_FORBIDDEN : $code);
    }
}
