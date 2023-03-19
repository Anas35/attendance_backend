<?php

namespace Tests\Feature;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        Department::factory()->create([
            'department_id' => 1,
        ]);
        
        $this->postJson(route('teacher.register'), [
            'teacherId' => '555',
            'teacherName' => 'Temp555',
            'email' => 'temp555@gmail.com',
            'password' => 'password',
            'departmentId' => 1,
            'profile' => UploadedFile::fake()->image('temp.jpg'),
        ]);
    }

    public function test_register()
    {
        Storage::fake('local');
        $email = fake()->email();

        $response = $this->postJson(route('teacher.register'), [
            'teacherId' => '101',
            'teacherName' => 'Teacher',
            'email' => $email,
            'password' => 'password',
            'departmentId' => 1,
            'profile' => UploadedFile::fake()->image('temp.jpg')
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'type', 'id', 'token'
        ]);
        $this->assertDatabaseHas('teachers', ['email' => $email]);
        $this->assertAuthenticated('teacher');

        $this->assertTrue(Storage::disk('local')->exists('\teachers\\101.png'));
    }

    public function test_register_validation_error()
    {
        Storage::fake('local');

        $response = $this->postJson(route('teacher.register'), [
            'teacherId' => '101',
            'teacherName' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => 'password',
            'profile' => UploadedFile::fake()->image('temp.jpg'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('departmentId');
        $this->assertDatabaseMissing('teachers', ['email' => 'teacher@gmail.com']);        
        $this->assertNotTrue(Storage::disk('local')->exists('\teachers\\101.png'));
    }

    public function test_register_validation_email_check()
    {

        $response = $this->postJson(route('teacher.register'), [
            'teacherId' => '111',
            'teacherName' => 'Teacher',
            'email' => 'temp555@gmail.com',
            'password' => 'password',
            'departmentId' => 1,
            'profile' => UploadedFile::fake()->image('temp.jpg'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $this->assertDatabaseMissing('teachers', ['teacherId' => '111']);   
        $this->assertNotTrue(Storage::disk('local')->exists('\teachers\\111.png'));
    }

    public function test_register_validation_incorrect_department_id()
    {
        $response = $this->postJson(route('teacher.register'), [
            'teacherId' => '111',
            'teacherName' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => 'password',
            'departmentId' => 2,
            'profile' => UploadedFile::fake()->image('temp.jpg'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('departmentId');
        $this->assertDatabaseMissing('teachers', ['teacherId' => '111']);        
        $this->assertNotTrue(Storage::disk('local')->exists('\teachers\\111.png'));
    }

    public function test_login()
    {
        $response = $this->postJson(route('teacher.login'), [
            'email' => 'temp555@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'type', 'id', 'token'
        ]);
        $this->assertAuthenticated('teacher');
    }

    public function test_login_invalid()
    {
        $response = $this->postJson(route('teacher.login'), [
            'email' => 'temp555@gmail.com',
            'password' => 'sceret',
        ]);

        $response->assertStatus(422);
        $this->assertFalse($this->isAuthenticated());
    }

    public function test_show()
    {
        $teacher = $this->postJson(route('teacher.login'), [
            'email' => 'temp555@gmail.com',
            'password' => 'password',
        ])->json();

        $response = $this->getJson(route('teacher.show', 555), [
            'Authorization' => 'Bearer '.$teacher['token'],
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['teacherName' => 'Temp555']);
        $response->assertJsonPath('data.departmentId', 1);
        $response->assertJsonStructure([
            'data' => [
                'teacherId',
                'teacherName',
                'email',
                'departmentId',
            ],
        ]);
    }

    public function test_show_auth()
    {
        $response = $this->getJson(route('teacher.show', 555));
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }

    public function test_show_not_exist()
    {
        $teacher = $this->postJson(route('teacher.login'), [
            'email' => 'temp555@gmail.com',
            'password' => 'password',
        ])->json();

        $response = $this->getJson(route('teacher.show', 100), [
            'Authorization' => 'Bearer '.$teacher['token'],
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
    }
}
