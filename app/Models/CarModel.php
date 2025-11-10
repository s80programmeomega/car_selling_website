<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class CarModel extends Model
{
    /** @use HasFactory<\Database\Factories\CarModelFactory> */
    use HasFactory;
    use AuditableTrait;

    protected $fillable = ['name', 'maker_id'];

    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'model_id');
    }
}
