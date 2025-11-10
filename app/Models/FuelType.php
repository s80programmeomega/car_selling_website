<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
