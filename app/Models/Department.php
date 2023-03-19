<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'department_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'department_id');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'department_id');
    }

    public function students()
    {
        return $this->hasMany(Students::class, 'department_id');
    }

    protected $primaryKey = 'department_id';

    protected $fillable = [
        'department_name',
        'head_of_department'
    ];
}
