<?php

namespace Tests\Feature;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        Department::factory()->create([
            'department_name' => 'Maths'
        ]);

        $response = $this->getJson(route('departments'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['departmentName' => 'Maths']);
        $response->assertJsonPath('data.0.departmentName', 'Maths');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'departmentId',
                    'departmentName'
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
