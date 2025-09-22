<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'class_id', 'subject_id', 'grade_id'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function gradeScale()
    {
        return $this->belongsTo(GradeScale::class, 'grade_id');
    }
}
