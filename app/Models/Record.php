<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'reg_no');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    protected $primaryKey = 'record_id';

    protected $fillable = [
        'reg_no',
        'class_id',
        'subject_id',
        'teacher_id',
        'is_present',
        'date',
    ];

}
