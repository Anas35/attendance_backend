<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassModelSeeder extends Seeder
{
    static private $class_names = array('I BCA', 'II BCA', 'III BCA');
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$class_names as $class_name) {
            \App\Models\ClassModel::factory(1)->create([
                'class_name' => $class_name . ' A',
            ]);
            \App\Models\ClassModel::factory(1)->create([
                'class_name' => $class_name . ' B',
            ]);
        }
    }
}
