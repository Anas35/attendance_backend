<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
    
    public function records()
    {
        return $this->hasMany(Record::class, 'record_id');
    }

    protected $primaryKey = 'subject_id';

    protected $fillable = [
        'subject_id',
        'subject_name',
        'semester',
        'department_id',
    ];
}
