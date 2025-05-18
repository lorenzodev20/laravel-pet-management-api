<?php

namespace App\Http\Controllers\Api\V1\Pet;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Services\TheCatApi\CatService;
use App\Http\Requests\SamplePaginatorRequest;
use App\Http\Resources\Api\V1\Pet\CatBreedsResource;
use App\Http\Resources\Api\V1\Pet\CatBreedsCollection;

class CatController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private CatService $catService
    ) {}

    public function breeds(SamplePaginatorRequest $request)
    {
        try {
            return new CatBreedsCollection(collect(
                $this->catService->breeds($request->getPage(), $request->getPerPage())
            ));
        } catch (\Throwable $th) {
            return $this->responseErrorByException($th);
        }
    }
}
