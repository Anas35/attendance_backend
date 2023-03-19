<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Query\Query;
use App\Http\Requests\V1\StoreStudentRequest;
use App\Http\Requests\V1\UpdateStudentRequest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        $filter = ['classId'];

        $students = Query::filtering($filter, request()->query(), $students);

        return new StudentCollection($students);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:students,email',
            'password' => 'required',
        ]);

        $credentials = array(
            'email' => $request->email,
            'password' => $request->password,
        );

        if (!Auth::guard('student')->attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 422);
        }

        $student = Auth::guard('student')->user();
        $token = $student->createToken('student-token', ['student-level'])->plainTextToken;

        return response()->json([
            'type' => 'student',
            'id' => $student->reg_no,
            'token' => $token
        ], 201);
    }

    public function register(StoreStudentRequest $request)
    {
        $reg_no = $request->get('regNo'); 
        $request->file('profile')->storeAs('students', $reg_no.'.png');

        $student = Student::create([
            'reg_no' => $request->regNo,
            //'roll_no' => $request->rollNo,
            'student_name' => $request->studentName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->departmentId,
            'class_id' => $request->classId,
        ]);

        $token = $student->createToken('student-token', ['student-level'])->plainTextToken;
        
        return response()->json([
            'type' => 'student', 
            'id' => $student->reg_no, 
            'token' => $token
        ], 201);
    }

    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->roll_no = (int) $request->get('rollNo');
        $student->student_name = $request->get('studentName');
        $student->email = $request->get('email');
        $student->department_id = (int) $request->get('departmentId');
        $student->class_id = (int) $request->get('classId');

        if ($request->has('profile')) {
            $request->file('profile')->storeAs('students', $student->reg_no.'.png');
        }

        return new StudentResource($student);
    }

}
