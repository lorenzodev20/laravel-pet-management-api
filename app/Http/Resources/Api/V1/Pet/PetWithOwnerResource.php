<?php

namespace App\Http\Resources\Api\V1\Pet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\Person\PersonResource;

/**
 * @mixin App\Models\Pet
 */
class PetWithOwnerResource extends JsonResource
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
            "image_url" => $this->image_url,
            "life_span" => $this->life_span,
            "adaptability" => $this->adaptability,
            "reference_image_id" => $this->reference_image_id,
            "created_at" => $this->created_at->format('Y-m-d'),
            "owner" => new PersonResource($this->person)
        ];
    }
}
