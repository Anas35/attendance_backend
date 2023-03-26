<?php

namespace App\Http\Resources;

use App\Http\Resources\V1\ClassResource;
use App\Http\Resources\V1\DepartmentResource;
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
            'studentName' => $this->student_name,
            'email' => $this->email,
            'department' => new DepartmentResource($this->department),
            'class' =>  new ClassResource($this->class),
        ];
    }
}
