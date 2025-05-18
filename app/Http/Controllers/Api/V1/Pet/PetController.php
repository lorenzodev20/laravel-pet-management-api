<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Pet;

use App\Models\Pet;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Repositories\PetRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PersonRepository;
use App\Http\Requests\SamplePaginatorRequest;
use App\Http\Resources\Api\V1\Pet\PetResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Api\V1\Pet\PetCollection;
use App\Http\Requests\Api\V1\Pet\CreatePetRequest;

class PetController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private PetRepository $petRepository,
        private PersonRepository $personRepository
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(SamplePaginatorRequest $request)
    {
        try {
            $query = $this->petRepository->samplePaginator(
                page: $request->getPage(),
                perPage: $request->getPerPage()
            );

            return new PetCollection($query);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePetRequest $request)
    {
        try {

            $model = new Pet();
            $model->name = $request->input("name");
            $model->species = $request->input("species");
            $model->breed = $request->input("breed");
            $model->age = $request->input("age");

            $model->person()->associate(
                $this->personRepository->get($request->input("person_id"))
            );

            $this->petRepository->save($model);
            return $this->responseWithoutData([
                "message" => "Registro creado!",
                "data" => new PetResource($model)
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        try {
            return $this->responseWithoutData(new PetResource($pet), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->petRepository->updateDirtyData($request, $id);
            return $this->responseWithData("Registro actualizado", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Pet::find($id)?->delete();
            return $this->responseWithData("Registro eliminado", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }
}
