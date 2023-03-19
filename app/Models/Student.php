<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class Student extends Authenticatable
{
    use HasApiTokens, HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
    
    public function records()
    {
        return $this->hasMany(Record::class, 'record_id');
    }

    protected $primaryKey = 'reg_no';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'reg_no',
        'student_name',
        'email',
        'password',
        'department_id',
        'class_id',
        'roll_no',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
