<?php

namespace App\Http\Resources\Api\V1\Person;

use App\Http\Resources\Api\V1\Pet\PetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin App\Models\Person
*/
class PersonWithPetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "birthdate" => $this->birthdate?->format('d-m-Y'),
            "pets" => PetResource::collection($this->pets()?->get()),
        ];
    }
}
