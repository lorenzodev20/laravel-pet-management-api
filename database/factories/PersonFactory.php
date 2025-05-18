<?php

namespace Database\Factories;

use Faker\Provider\en_US\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement([Person::GENDER_MALE, Person::GENDER_FEMALE]);
        return [
            'name' => fake()->name($gender),
            'email' => fake()->email(),
            'birthdate' => fake()->date(),
        ];
    }
}
