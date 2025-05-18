<?php

namespace Tests\Feature\Controllers\Api\V1\Pet;

use App\Models\Pet;
use Tests\TestCase;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use App\Repositories\PetRepository;
use App\Repositories\PersonRepository;
use App\Services\Pet\CompletePetService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PetControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $petRepository;
    protected $personRepository;
    protected $completePetService;
    protected $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->petRepository = $this->mock(PetRepository::class);
        $this->personRepository = $this->mock(PersonRepository::class);
        $this->completePetService = $this->mock(CompletePetService::class);

        $user = \App\Models\User::factory()->create();
        $token = auth()->login($user);
        $this->headers = [
            'Authorization' => "Bearer $token"
        ];
    }

    public function test_it_can_list_pets()
    {
        $pets = Pet::factory()->count(3)->create();

        $this->petRepository
            ->shouldReceive('samplePaginator')
            ->once()
            ->andReturn(Pet::paginate());

        $response =  $this->getJson('/api/v1/pet?page=1&perPage=10', $this->headers);

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_it_can_create_a_pet()
    {
        $person = Person::factory()->create();

        $this->personRepository
            ->shouldReceive('get')
            ->once()
            ->andReturn($person);

        $this->petRepository
            ->shouldReceive('save')
            ->once();

        $this->completePetService
            ->shouldReceive('completeBreedInformation')
            ->once();

        $data = [
            'name' => 'Misifú',
            'species' => 'cat',
            'breed' => 'Angora',
            'age' => 2,
            'person_id' => $person->id,
            'created_at' => now()
        ];


        $response = $this->postJson('api/v1/pet', $data, $this->headers);

        $response->assertCreated()
            ->assertJsonStructure(['message', 'data']);
    }

    public function test_it_can_show_a_pet()
    {
        $pet = Pet::factory()->create();

        $response = $this->getJson('api/v1/pet/' . $pet?->id, $this->headers);

        $response->assertOk()
            ->assertJsonStructure([
                'id',
                'name',
                'species',
                'breed',
                'age',
                'image_url',
                'life_span',
                'adaptability',
                'reference_image_id',
                'created_at',
            ]);
    }

    public function test_it_can_update_a_pet()
    {
        $pet = Pet::factory()->create();

        $this->petRepository
            ->shouldReceive('updateDirtyData')
            ->once();

        $this->completePetService
            ->shouldReceive('completeBreedInformation')
            ->once();

        $response = $this->putJson('api/v1/pet/' . $pet->id, [
            'name' => 'Nuevo nombre',
            'species' => 'Gato',
            'breed' => 'Abyssinian',
            'age' => 2,
            'person_id' => $pet->person?->id,
        ], $this->headers);

        $response->assertOk()
            ->assertJsonFragment(['message' => 'Registro actualizado']);
    }

    public function test_it_can_delete_a_pet()
    {
        $pet = Pet::factory()->create();

        $response = $this->deleteJson(uri: 'api/v1/pet/' . $pet->id, headers: $this->headers);

        $response->assertOk()
            ->assertJsonFragment(['message' => 'Registro eliminado']);
    }
}
