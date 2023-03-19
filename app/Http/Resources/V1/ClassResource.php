<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $department = $this->whenLoaded('department');
        $missing = $department instanceof \Illuminate\Http\Resources\MissingValue;

        return [
            'classId' => $this->class_id,
            'className' => $this->class_name,
            'mentor' => $this->mentor,
            'strength' => $this->strength,
            'departmentId' => $this->when($missing, $this->department_id),
            'department' => new DepartmentResource($department),
        ];
    }
}
