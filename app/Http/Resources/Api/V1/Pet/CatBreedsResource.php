<?php

namespace App\Http\Resources\Api\V1\Pet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatBreedsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'wikipedia_url' => $this['wikipedia_url'],
        ];
    }
}
