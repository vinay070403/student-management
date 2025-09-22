<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state_id', 'address', 'zipcode'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function users()
    {
        return $this->hasMany(User::class)->where('role', 'student');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function gradeScales()
    {
        return $this->hasMany(GradeScale::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }
}
