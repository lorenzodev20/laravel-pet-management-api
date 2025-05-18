<?php

namespace App\Http\Requests\Api\V1\Person;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "string|max:255",
            "email" => [
                "string",
                "email",
                "max:255",
                Rule::unique('people', 'email')->ignore($this->route('person')),
            ],
            "birthdate" => "date_format:Y-m-d"
        ];
    }
}
