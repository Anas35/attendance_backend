<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Models\Student::class;   

    private static $reg_no = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reg_no' => '31120U090' . self::$reg_no++,
            'student_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'roll_no' => fake()->numberBetween(1, 50),
            'department_id' => Models\Department::all('department_id')->first(),
            'class_id' => Models\ClassModel::all('class_id')->first(),
            'remember_token' => Str::random(10),
        ];
    }
}
