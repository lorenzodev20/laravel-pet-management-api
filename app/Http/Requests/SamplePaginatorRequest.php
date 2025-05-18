<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SamplePaginatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "page" => "required|integer",
            "perPage" => "required|integer",
        ];
    }

    public function getPage(): int
    {
        return $this->get('page') ?? 1;
    }

    public function getPerPage(): int
    {
        return $this->get('perPage') ?? 10;
    }
}
