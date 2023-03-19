<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reg_no' => \App\Models\Student::all('reg_no')->random(),
            'class_id' => \App\Models\ClassModel::all('class_id')->random(),
            'subject_id' => \App\Models\Subject::all('subject_id')->random(),
            'teacher_id' => \App\Models\Teacher::all('teacher_id')->random(),
            'is_present' => rand(0, 1),
            'date' => fake()->dateTime(),
        ];
    }
}
