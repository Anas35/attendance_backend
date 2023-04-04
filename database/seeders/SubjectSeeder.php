<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = ['Computer Graphics', 'Programming in C', 'Computer Network', 'DBMS',];
        foreach ($array as $sub) {
            \App\Models\Subject::factory(1)->create([
                'subject_name' => $sub,
            ]);
        }
    }
}
