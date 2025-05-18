<?php

namespace App\Http\Requests\Api\V1\Person;

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
            "email" => "string|email|max:255|unique:people",
            "birthdate" => "date_format:Y-m-d"
        ];
    }
}
