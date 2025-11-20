<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    // Add 'ulid' to fillable
    protected $fillable = ['school_id', 'name', 'ulid'];

    // Automatically generate ULID when creating a new record
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($SchoolClass) {
            if (!$SchoolClass->ulid) {
                $SchoolClass->ulid = Str::ulid();
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
        return $this->hasMany(StudentGrade::class, 'class_id');
    }
}
