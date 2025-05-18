<?php

namespace App\Http\Resources\Api\V1\Pet;

use App\Http\Resources\Api\V1\Person\PersonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin App\Models\Pet
 */
class PetResource extends JsonResource
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
            "species" => $this->species,
            "breed" => $this->breed,
            "age" => $this->age,
            "created_at" => $this->created_at->format('Y-m-d')
        ];
    }
}
