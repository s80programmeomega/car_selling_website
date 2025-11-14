<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Yajra\Auditable\AuditableTrait;

class Maker extends Model
{
    /** @use HasFactory<\Database\Factories\MakerFactory> */
    use HasFactory;
    use AuditableTrait;

    protected $fillable = ['name', 'logo'];

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }


    protected static function booted()
    {
        // static::saved(fn() => Cache::forget('makers')); // or car-types, etc.
        // static::deleted(fn() => Cache::forget('makers'));
        static::created(fn() => Cache::forget('dropdown-makers'));
        static::updated(fn() => Cache::forget('dropdown-makers'));
        static::deleted(fn() => Cache::forget('dropdown-makers'));
    }

}
