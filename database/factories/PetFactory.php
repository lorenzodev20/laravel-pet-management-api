<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->name(),
            "species" => fake()->randomElement(['cat', 'dog']),
            "breed" => fake()->randomElement(['criollo', 'fino']),
            "age" => fake()->numberBetween(1,9),
            "person_id" => Person::factory()
        ];
    }
}
