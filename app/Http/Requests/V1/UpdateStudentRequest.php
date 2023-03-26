<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        $student = request()->route('student');

        return $user != null && $user->tokenCan('student-level')  && $user->reg_no == $student->reg_no;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'studentName' => 'required',
            'email' => 'required|email',
            'departmentId' => 'required|exists:departments,department_id',
            'classId' => 'required|exists:classes,class_id',
            'profile' => 'image|mimes:jpg,png,jpeg',
        ];
    }
}
