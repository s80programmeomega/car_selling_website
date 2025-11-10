<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Feature extends Model
{
    /** @use HasFactory<\Database\Factories\FeatureFactory> */
    use HasFactory;
    use AuditableTrait;

    protected $fillable = ['name', 'description', 'category'];

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_features');
    }
}
