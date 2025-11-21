<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state_id', 'country_id', 'address', 'zipcode', 'ulid'];

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

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
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
        return $this->hasMany(SchoolClass::class,  'school_id', 'id');
        // return $this->hasMany(\App\Models\SchoolClass::class);
    }
}
