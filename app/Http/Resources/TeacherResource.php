<?php

namespace App\Http\Resources;

use App\Http\Resources\V1\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'teacherId' => $this->teacher_id,
            'teacherName' => $this->teacher_name,
            'email' => $this->email,
            'department' => new DepartmentResource($this->department),
        ];
    }
}
