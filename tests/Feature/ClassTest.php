<?php

namespace Tests\Feature;

use App\Models\ClassModel;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassTest extends TestCase
{
    
    use RefreshDatabase;

    public function test_index()
    {
        $dept = Department::factory()->create([
            'department_id' => 10,
        ]);

        ClassModel::factory()->create([
            'class_name' => 'III CS'
        ]);

        $response = $this->getJson(route('classes'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['className' => 'III CS']);
        $response->assertJsonPath('data.0.className', 'III CS');
        $response->assertJsonPath('data.0.departmentId', 10);
        $response->assertJsonMissingPath('data.department.departmentId');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'classId',
                    'className',
                    'strength',
                    'mentor',
                    'departmentId'
                ],
            ],
        ]);
    }

    public function test_show()
    {
        Department::factory()->create([
            'department_id' => 10,
        ]);

        ClassModel::factory()->create([
            'class_id' => 1011,
            'class_name' => 'III CS'
        ]);

        $response = $this->getJson(route('class', 1011));

        $response->assertStatus(200);
        $response->assertJsonFragment(['className' => 'III CS']);
        $response->assertJsonPath('data.className', 'III CS');
        $response->assertJsonPath('data.departmentId', 10);
        $response->assertJsonMissingPath('data.department.departmentId');
        $response->assertJsonStructure([
            'data' => [
                'classId',
                'className',
                'strength',
                'mentor',
                'departmentId'
            ],
        ]);
    }

    public function test_show_not_found()
    {

        $response = $this->getJson(route('class', 1011));

        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
    }

    public function test_show_with_department()
    {
        Department::factory()->create([
            'department_id' => 10,
        ]);

        ClassModel::factory()->create([
            'class_id' => 1011,
            'class_name' => 'III CS'
        ]);

        $response = $this->getJson(route('class', ['class' => 1011, 'includeDept']));

        $response->assertStatus(200);
        $response->assertJsonFragment(['className' => 'III CS']);
        $response->assertJsonPath('data.className', 'III CS');
        $response->assertJsonPath('data.department.departmentId', 10);
        $response->assertJsonMissingPath('data.departmentId');
        $response->assertJsonStructure([
            'data' => [
                'classId',
                'className',
                'strength',
                'mentor',
                'department' => [
                    'departmentId',
                    'departmentName',
                ],
            ],
        ]);
    }

    public function test_not_allowed()
    {
        $response = $this->postJson(route('departments'));
        $response->assertStatus(405);
    }
}
