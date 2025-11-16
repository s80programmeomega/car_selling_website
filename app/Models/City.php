<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Yajra\Auditable\AuditableTrait;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;
    use AuditableTrait;

    protected $fillable = ['name', 'state_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    protected static function booted()
    {
        static::saved(fn($city) => Cache::tags(['dropdowns'])->forget("cities-state-{$city->state_id}"));
        static::deleted(fn($city) => Cache::tags(['dropdowns'])->forget("cities-state-{$city->state_id}"));
    }
}
