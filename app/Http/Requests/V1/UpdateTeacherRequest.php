<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        
        $user = $this->user();

        return $user != null && $user->tokenCan('teacher-level');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'teacherName' => 'required',
            'email' => 'required|email',
            'departmentId' => 'required|exists:departments,department_id',
            'profile' => 'image|mimes:jpg,png,jpeg',
        ];
    }
}
