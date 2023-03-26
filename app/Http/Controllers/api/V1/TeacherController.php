<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Requests\V1\StoreTeacherRequest;
use App\Http\Requests\V1\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:teachers,email',
                'password' => 'required',
            ]);

            $credentials = array(
                'email' => $request->email,
                'password' => $request->password,
            );
    
            if (!Auth::guard('teacher')->attempt($credentials)) {
                return response()->json([
                    'message' => 'The provided credentials are incorrect.',
                ], 422);
            }
    
            $teacher = Auth::guard('teacher')->user();
    
            $token = $teacher->createToken('teacher-token', ['teacher-level'])->plainTextToken;
            
            return response()->json([
                'type' => 'teacher',
                'id' => strval($teacher->teacher_id), 
                'token' => $token
            ], 201);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return response()->json([
                'message' => 'Server Error, Please Try again or Contact Support'
            ], 500);
        }
    }

    public function register(StoreTeacherRequest $request)
    {
        try {
            $teacher_id = $request->get('teacherId'); 
            $request->file('profile')->storeAs('teachers', $teacher_id.'.png');

            $teacher = Teacher::create([
                'teacher_id' => $teacher_id,
                'teacher_name' => $request->teacherName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'department_id' => $request->departmentId
            ]);

            Auth::guard('teacher')->setUser($teacher);
            $token = $teacher->createToken('teacher-token', ['teacher-level'])->plainTextToken;

            return response()->json([
                'type' => 'teacher', 
                'id' => strval($teacher->teacher_id), 
                'token' => $token
            ], 201);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return response()->json([
                'message' => 'Server Error, Please Try again or Contact Support'
            ], 500);
        }
    }

    public function show(Teacher $teacher)
    {
        $result = Teacher::with(['department'])->find($teacher->teacher_id);
        return new TeacherResource($result);
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->teacher_name = $request->get('teacherName');
        $teacher->email = $request->get('email');
        $teacher->department_id = $request->get('departmentId');
        $teacher->save();

        if ($request->has('profile')) {
            $request->file('profile')->storeAs('teachers', $teacher->teacher_id.'.png');
        }

        return new TeacherResource($teacher);
    }

}
