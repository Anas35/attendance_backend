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

        return $user != null && $user->tokenCan('student-level');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'rollNo' => 'required|integer',
            'studentName' => 'required',
            'email' => 'required|email',
            'departmentId' => 'required|exists:departments,department_id',
            'classId' => 'required|exists:classes,class_id'
        ];
    }
}
