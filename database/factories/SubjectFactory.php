<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject_id' => fake()->numberBetween(1000, 6000),
            'subject_name' => fake()->unique()->word(),
            'semester' => fake()->numberBetween(1, 6),
            'department_id' => \App\Models\Department::all()->first(),
        ];
    }
}
