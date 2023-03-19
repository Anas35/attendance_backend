<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
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
            'recordId' => $this->when(isset($this->record_id), fn() => $this->record_id),
            'regNo' => $this->when(isset($this->reg_no), fn() => $this->reg_no),
            'subjectId' => $this->when(isset($this->subject_id), fn() => $this->subject_id),
            'subjectName' => $this->when(
                isset($this->subject_name) || isset($this->subject->subject_name), 
                fn() => $this->subject_name ?? $this->subject->subject_name,
            ),
            'teacherId' => $this->when(isset($this->teacher_id), fn() => $this->teacher_id),
            'classId' => $this->when(isset($this->class_id), fn() => $this->class_id),
            'present' => $this->when(isset($this->present), fn() => $this->present),
            'absent' => $this->when(isset($this->absent), fn() => $this->absent),
            'percentage' =>  $this->when(isset($this->percentage), fn() => $this->percentage),
            'isPresent' => $this->when(isset($this->is_present), fn() => $this->is_present),
        ];
    }
}