<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GradeScale extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'grade', 'min_score', 'max_score', 'grade_point', 'ulid'];

    // Automatically generate ULID when creating a new record
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->ulid) {
                $model->ulid = Str::ulid();
            }
        });
    }

    // Use ULID for route model binding
    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class, 'grade_id');
    }
}
