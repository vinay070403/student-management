<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'name', 'ulid'];

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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
