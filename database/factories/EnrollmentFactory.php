<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = $this->faker->year();
        return [
            'school_year' => $year . '-' . ($year + 1),
            'school_moment' => $this->faker->numberBetween(1, 3), // Assuming 1-4 represents different school moments
            'section' => $this->faker->randomLetter(),
            'classroom' => $this->faker->numberBetween(100, 200),
        ];
    }
}
