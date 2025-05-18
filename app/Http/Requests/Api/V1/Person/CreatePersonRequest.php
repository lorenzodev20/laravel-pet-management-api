<?php

namespace App\Http\Requests\Api\V1\Person;

use Illuminate\Foundation\Http\FormRequest;

class CreatePersonRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:people",
            "birthdate" => "required|date_format:Y-m-d"
        ];
    }
}
