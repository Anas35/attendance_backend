<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'regNo' => $this->reg_no,
            'rollNo' => $this->roll_no,
            'studentName' => $this->student_name,
            'email' => $this->email,
            'departmentId' => $this->department_id,
            'classId' => $this->class_id,
            'token' => $this->when(isset($this->token), fn() => $this->token)
        ];
    }
}
