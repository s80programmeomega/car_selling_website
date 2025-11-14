<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Yajra\Auditable\AuditableTrait;

class CarType extends Model
{
    /** @use HasFactory<\Database\Factories\CarTypeFactory> */
    use HasFactory;
    use AuditableTrait;

    protected $fillable = ['name', 'description'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }


    protected static function booted()
    {
        // static::saved(fn() => Cache::forget('carTypes'));
        // static::deleted(fn() => Cache::forget('carTypes'));
        static::created(fn() => Cache::forget('dropdown-car-types'));
        static::updated(fn() => Cache::forget('dropdown-car-types'));
        static::deleted(fn() => Cache::forget('dropdown-car-types'));
    }

}
