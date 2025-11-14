<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Yajra\Auditable\AuditableTrait;

class State extends Model
{
    /** @use HasFactory<\Database\Factories\StateFactory> */
    use HasFactory;
    use AuditableTrait;

    protected $fillable = ['name', 'code'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }


    protected static function booted()
    {
        // static::saved(fn() => Cache::forget('states'));
        // static::deleted(fn() => Cache::forget('states'));

        static::created(fn() => Cache::forget('dropdown-states'));
        static::updated(fn() => Cache::forget('dropdown-states'));
        static::deleted(fn() => Cache::forget('dropdown-states'));
    }

}
