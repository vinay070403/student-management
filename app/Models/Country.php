<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ulid'];

    // Automatically generate ULID on creation
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($country) {
            if (!$country->ulid) {
                $country->ulid = Str::ulid(); // generate ULID for new records
            }
        });
    }

    /**
     * Use ULID for route model binding if available,
     * otherwise fallback to id for old rows.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('ulid', $value)->orWhere('id', $value)->firstOrFail();
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
