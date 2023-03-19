<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'regNo' => 'required',
            //'rollNo' => 'required|integer',
            'studentName' => 'required',
            'email' => 'required|email|unique:students,email',
            'password' => 'required',
            'departmentId' => 'required|exists:departments,department_id',
            'classId' => 'required|exists:classes,class_id'
        ];
    }
}
