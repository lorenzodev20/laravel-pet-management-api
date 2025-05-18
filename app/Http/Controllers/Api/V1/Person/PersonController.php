<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Person;

use App\Models\Person;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Knuckles\Scribe\Attributes\Group;
use App\Repositories\PersonRepository;
use App\Http\Requests\SamplePaginatorRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Api\V1\Person\PersonResource;
use App\Http\Resources\Api\V1\Person\PersonCollection;
use App\Http\Requests\Api\V1\Person\CreatePersonRequest;
use App\Http\Requests\Api\V1\Person\UpdatePersonRequest;
use Knuckles\Scribe\Attributes\Authenticated;

#[Group("Personas", "API RESTful para la gestión de las personas dueñas de las mascotas")]
#[Authenticated()]
class PersonController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private PersonRepository $personRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(SamplePaginatorRequest $request): JsonResponse|PersonCollection
    {
        try {
            $query = $this->personRepository->samplePaginator(
                page: $request->getPage(),
                perPage: $request->getPerPage()
            );

            return new PersonCollection($query);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePersonRequest $request): JsonResponse
    {
        try {

            $model = new Person();
            $model->name = $request->input('name');
            $model->email = $request->input('email');
            $model->birthdate = $request->input('birthdate');
            $this->personRepository->save($model);
            return $this->responseWithData("Registro creado!", Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person): JsonResponse
    {
        try {
            return $this->responseWithoutData(new PersonResource($person), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, int $id): JsonResponse
    {
        try {
            $this->personRepository->updateDirtyData($request, $id);
            return $this->responseWithData("Registro actualizado", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            Person::find($id)?->delete();
            return $this->responseWithData("Registro eliminado", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }
}
