<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreBulkRecordRequest extends FormRequest
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
            'classId' => 'required|exists:classes,class_id',
            'teacherId' => 'required|exists:teachers,teacher_id',
            'subjectId' => 'required|exists:subjects,subject_id',
            'students.*.regNo' => 'required|exists:students,reg_no',
            'students.*.isPresent' => 'required|boolean',
            'date' => 'nullable|date_format:Y-m-d',
        ];
    }
}
