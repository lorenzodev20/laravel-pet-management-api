<?php

namespace Tests\Feature\Controllers\Api\V1\Person;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Person;
use App\Repositories\PersonRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $personRepository;
    protected $headers;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock del repositorio
        $this->personRepository = Mockery::mock(PersonRepository::class);
        $this->app->instance(PersonRepository::class, $this->personRepository);

        $user = \App\Models\User::factory()->create();
        $token = auth()->login($user);
        $this->headers = [
            'Authorization' => "Bearer $token"
        ];
    }

    public function test_it_can_list_people()
    {
        $this->personRepository
            ->shouldReceive('samplePaginator')
            ->once()
            ->andReturn(Person::paginate());

        $response = $this->getJson('/api/v1/person?page=1&perPage=10', $this->headers);

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_it_can_create_a_person()
    {
        $payload = [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'birthdate' => '1990-05-10',
        ];

        $this->personRepository
            ->shouldReceive('save')
            ->once();

        $response = $this->postJson('/api/v1/person', $payload, $this->headers);

        $response->assertCreated()
            ->assertJsonFragment(['message' => 'Registro creado!']);
    }

    public function test_it_can_show_a_person()
    {
        $person = Person::factory()->create();

        $response = $this->getJson("/api/v1/person/{$person->id}", $this->headers);

        $response->assertOk()
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'birthdate',
            ]);
    }

    public function test_it_can_update_a_person()
    {
        $person = Person::factory()->create();

        $payload = [
            'name' => 'Nombre actualizado',
            'email' => $person->email,
            'birthdate' => $person->birthdate?->format('Y-m-d'),
        ];

        $this->personRepository
            ->shouldReceive('updateDirtyData')
            ->once()
            ->withArgs(function ($request, $id) use ($person) {
                return $id === $person->id;
            });

        $response = $this->putJson("/api/v1/person/{$person->id}", $payload, $this->headers);

        $response->assertOk()
            ->assertJsonFragment(['message' => 'Registro actualizado']);
    }

    public function test_it_can_delete_a_person()
    {
        $person = Person::factory()->create();

        $response = $this->deleteJson("/api/v1/person/{$person->id}", [], $this->headers);

        $response->assertOk()
            ->assertJsonFragment(['message' => 'Registro eliminado']);
        $this->assertSoftDeleted(Person::class, ['id' => $person->id]);
    }
}
