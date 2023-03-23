<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentRecordResource extends JsonResource
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
            'present' => $this->present,
            'absent' => $this->absent,
            'percentage' =>  $this->percentage,
            'records' => SubjectRecordResource::collection($this->records),
        ];
    }
}

class SubjectRecordResource extends JsonResource
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
            'present' => $this->present,
            'absent' => $this->absent,
            'percentage' =>  $this->percentage,
        ];
    }
}