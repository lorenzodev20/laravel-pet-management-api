<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use PHPUnit\Metadata\Test;
use Illuminate\Support\Facades\Http;
use App\Services\TheCatApi\CatService;

class CatServiceTest extends TestCase
{
    private CatService $service;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.cat_api.url' => 'https://fake-cat-api.com',
            'services.cat_api.api_key' => 'fake-api-key',
        ]);

        $this->service = new CatService();
    }

    public function test_it_fetches_cat_breeds(): void
    {
        Http::fake([
            'https://fake-cat-api.com/v1/breeds*' => Http::response([
                ['id' => 'abys', 'name' => 'Abyssinian'],
                ['id' => 'beng', 'name' => 'Bengal']
            ], 200)
        ]);

        $breeds = $this->service->breeds(1, 10);

        $this->assertIsArray($breeds);
        $this->assertCount(2, $breeds);
        $this->assertEquals('Abyssinian', $breeds[0]['name']);
    }

    public function test_it_fetches_breed_properties(): void
    {
        Http::fake([
            'https://fake-cat-api.com/v1/breeds/search*' => Http::response([
                (object)[
                    'id' => 'abys',
                    'name' => 'Abyssinian',
                    'temperament' => 'Active, Energetic'
                ]
            ], 200)
        ]);

        $properties = $this->service->getBreedProperties('abys');

        $this->assertIsArray($properties);
        $this->assertEquals('Abyssinian', $properties[0]->name);
    }

    public function test_it_fetches_reference_image(): void
    {
        $url = fake()->url();
        Http::fake([
            'https://fake-cat-api.com/v1/images/abc123' => Http::response([
                'id' => 'abc123',
                'url' => $url
            ], 200)
        ]);

        $image = $this->service->getReferenceImage('abc123');
        // dd($image);
        $this->assertIsObject($image);
        $this->assertEquals('abc123', $image->id);
        $this->assertEquals($url, $image->url);
    }
}
