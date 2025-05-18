<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Person;

use App\Models\Person;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Repositories\PetRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PersonRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Api\V1\Person\PersonResource;
use App\Http\Resources\Api\V1\Person\PersonWithPetResource;

class PersonWithPetsController extends Controller
{
    use ApiResponseTrait;

    public function index(Person $person): JsonResponse
    {
        try {
            return $this->responseWithoutData(new PersonWithPetResource($person), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }
}
