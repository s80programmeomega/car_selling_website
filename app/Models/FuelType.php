<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Yajra\Auditable\AuditableTrait;

class FuelType extends Model
{
    /** @use HasFactory<\Database\Factories\FuelTypeFactory> */
    use HasFactory;
    use AuditableTrait;

    protected $fillable = ['name', 'description'];

    public function cars() {
        return $this->hasMany(Car::class);
    }


    protected static function booted()
    {
        // static::saved(fn() => Cache::forget('fuelTypes'));
        // static::deleted(fn() => Cache::forget('fuelTypes'));
    
        static::created(fn() => Cache::forget('dropdown-fuel-types'));
        static::updated(fn() => Cache::forget('dropdown-fuel-types'));
        static::deleted(fn() => Cache::forget('dropdown-fuel-types'));

    }

}
