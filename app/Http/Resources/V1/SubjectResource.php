<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'subjectId' => $this->subject_id,
            'subjectName' => $this->subject_name,
            'semester' => $this->semester,
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'departmentId' => $this->department_id,
        ];
    }
}
