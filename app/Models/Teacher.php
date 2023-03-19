<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
    
    public function records()
    {
        return $this->hasMany(Record::class, 'record_id');
    }

    protected $primaryKey = 'teacher_id';

    protected $guard = 'teacher';

    protected $fillable = [
        'teacher_id',
        'teacher_name',
        'email',
        'password',
        'department_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
