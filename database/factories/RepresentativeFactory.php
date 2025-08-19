<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Representative>
 */
class RepresentativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idcard' => $this->faker->numerify('########'),
            'phone' => $this->faker->numerify('#########'),
            'name' => $this->faker->name(),
            'surname'=> $this->faker->lastName(),
            'direction' => $this->faker->city()
        ];
    }
}
