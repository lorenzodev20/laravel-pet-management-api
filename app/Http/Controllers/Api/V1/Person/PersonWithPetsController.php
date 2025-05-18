<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Person;

use App\Models\Person;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Repositories\PetRepository;
use App\Http\Controllers\Controller;
use Knuckles\Scribe\Attributes\Group;
use App\Repositories\PersonRepository;
use Knuckles\Scribe\Attributes\Authenticated;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Api\V1\Person\PersonResource;
use App\Http\Resources\Api\V1\Person\PersonWithPetResource;

#[Group("Reporte de mascotas", "API para ver las mascotas que tiene una persona")]
#[Authenticated()]
class PersonWithPetsController extends Controller
{
    use ApiResponseTrait;

    /**
     * Devuelve una persona con sus mascotas
     * @response 200 {"id":111,"name":"Pepito","email":"pepito123@gmail.com","birthdate":"13-08-1995","pets":[{"id":11,"name":"Michilina","species":"cat","breed":"angora","age":"10.00","image_url":null,"life_span":null,"adaptability":null,"reference_image_id":null,"created_at":"2025-05-18"},{"id":12,"name":"Minina","species":"cat","breed":"Criolla","age":"8.00","image_url":null,"life_span":null,"adaptability":null,"reference_image_id":null,"created_at":"2025-05-18"},{"id":13,"name":"Minina","species":"cat","breed":"Criolla","age":"8.00","image_url":null,"life_span":null,"adaptability":null,"reference_image_id":null,"created_at":"2025-05-18"},{"id":14,"name":"Minina Acur","species":"cat","breed":"Abyssinian","age":"8.00","image_url":"https:\/\/cdn2.thecatapi.com\/images\/0XYvRd7oD.jpg","life_span":"14 - 15","adaptability":5,"reference_image_id":"0XYvRd7oD","created_at":"2025-05-18"},{"id":15,"name":"Minina Acur  sdsdsdsd","species":"Gato","breed":"Abyssinian","age":"5.00","image_url":"https:\/\/cdn2.thecatapi.com\/images\/0XYvRd7oD.jpg","life_span":"14 - 15","adaptability":5,"reference_image_id":"0XYvRd7oD","created_at":"2025-05-18"}]}
    */
    public function index(Person $person): JsonResponse
    {
        try {
            return $this->responseWithoutData(new PersonWithPetResource($person), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }
}
