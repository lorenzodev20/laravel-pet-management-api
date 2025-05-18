<?php

namespace App\Http\Requests\Api\V1\Pet;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => "required|string|max:60",
            'species' => "required|string|max:60",
            'breed' => "required|string|max:60",
            'age' => "required|integer",
            "person_id" => ["required", "integer", "exists:people,id"]
        ];
    }
}
