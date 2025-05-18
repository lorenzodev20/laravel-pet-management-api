<?php

namespace Tests\Unit\Traits;

use Exception;
use Tests\TestCase;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseTraitTest extends TestCase
{
    use ApiResponseTrait;

    public function test_it_returns_json_response_with_data()
    {
        $message = 'Operación exitosa';
        $response = $this->responseWithData($message, Response::HTTP_OK);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['data' => $message], $response->getData(true));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function test_it_returns_json_response_without_data_wrapper()
    {
        $data = ['name' => 'Lorenzo', 'email' => 'test@example.com'];
        $response = $this->responseWithoutData($data, Response::HTTP_OK);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($data, $response->getData(true));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function test_it_returns_json_response_on_exception_and_logs_error()
    {
        Log::shouldReceive('error')->once();

        $exception = new Exception('Algo salió mal');
        $response = $this->responseErrorByException($exception);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['message' => 'Algo salió mal'], $response->getData(true));
        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function test_it_defaults_to_generic_message_when_exception_message_is_empty()
    {
        Log::shouldReceive('error')->once();

        $exception = new Exception('');
        $response = $this->responseErrorByException($exception);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(
            ['message' => 'En este momento no puede procesarse su solicitud, intente de nuevo más tarde.'],
            $response->getData(true)
        );
    }
}
