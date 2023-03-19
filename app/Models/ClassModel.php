<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function students()
    {
        return $this->hasMany(Students::class, 'reg_no');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'class_id', 'class_id');
    }

    protected $table = 'classes';

    protected $primaryKey = 'class_id';

    protected $fillable = [
        'class_name',
        'mentor',
        'strength',
        'department_id',
    ];
}
