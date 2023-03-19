<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassModel>
 */
class ClassModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'mentor' => fake()->name(),
            'strength' => fake()->numberBetween(30, 50),
            'department_id' => \App\Models\Department::all()->first(),
        ];
    }
}
