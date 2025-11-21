<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'avatar',
        'address',
        'student_id',
        'country_id',
        'state_id',
        'zipcode',
        'password',
        'interest',
        'goal',
        'ulid', // ✅ Add ULID to fillable if you’ll set manually anywhere
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ✅ Automatically generate ULID on create
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->ulid)) {
                $user->ulid = (string) Str::ulid();
            }
        });
    }

    // ✅ Tell Laravel to use ULID for route model binding
    public function getRouteKeyName()
    {
        return 'ulid';
    }

    

    // ✅ Accessor for avatar URL
    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? asset('storage/avatars/' . $this->avatar)
            : asset('assets/images/default-avatar.png');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class, 'student_id');
    }
}
