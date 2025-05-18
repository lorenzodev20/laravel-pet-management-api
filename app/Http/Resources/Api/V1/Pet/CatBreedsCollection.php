<?php

namespace App\Http\Resources\Api\V1\Pet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CatBreedsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

     public $collects = 'App\Http\Resources\Api\V1\Pet\CatBreedsResource';
}
