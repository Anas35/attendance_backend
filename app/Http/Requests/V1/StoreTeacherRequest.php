<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'teacherId' => 'required|unique:teachers,teacher_id',
            'teacherName' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required',
            'departmentId' => 'required|exists:departments,department_id',
            'profile' => 'image|mimes:jpg,png,jpeg',
        ];
    }
}
