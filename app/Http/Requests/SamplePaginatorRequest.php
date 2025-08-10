<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Query parameters
 */
class SamplePaginatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "page" => ['required', 'integer', 'min:1'],
            "perPage" => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->mergeIfMissing([
            'page' => 1,
            'perPage' => 10,
        ]);
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
