<?php

declare(strict_types=1);

namespace App\Services\TheCatApi;

use Illuminate\Support\Facades\Http;

class CatService
{
    const TOKEN_TYPE = 'x-api-key';
    public ?string $baseUrl;
    public ?string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.cat_api.url');
        $this->token = config('services.cat_api.api_key');
    }

    public function breeds(int $page, int $perPage): ?string
    {
        return Http::withToken($this->token, self::TOKEN_TYPE)->get("{$this->baseUrl}/v1/breeds", [
            'page' => $page,
            'limit' => $perPage,
        ])?->json();
    }

    public function getBreedProperties(string $breed)
    {
        return Http::withToken($this->token, self::TOKEN_TYPE)
            ->get("{$this->baseUrl}/v1/breeds/search", [
                "q" => $breed,
                "attach_image" => 1
            ])?->object();
    }

    public function getReferenceImage(string $referenceImageId)
    {
        return Http::withToken($this->token, self::TOKEN_TYPE)
            ->get("{$this->baseUrl}/v1/images/{$referenceImageId}")?->object();
    }
}
