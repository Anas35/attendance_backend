<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = ['Computer Science', 'Maths', 'Chemistry', 'Physics', 'Commerce'];
        foreach ($array as $deptName) {
            \App\Models\Department::factory(1)->create([
                'name' => $deptName
            ]);
        }
    }
}
