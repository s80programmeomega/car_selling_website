<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;
    use AuditableTrait;

    protected $fillable = [
        'owner_id', 'maker_id', 'model_id', 'car_type_id', 'fuel_type_id',
        'state_id', 'city_id', 'year', 'price', 'mileage', 'vin_code',
        'address', 'phone', 'description', 'published', 'featured',
        'transmission', 'color', 'interior_color', 'doors', 'seats',
        'engine_size', 'condition', 'accident_history', 'number_of_owners',
        'view_count', 'sold_at', 'status'
    ];

    protected $casts = [
        'published' => 'boolean',
        'featured' => 'boolean',
        'accident_history' => 'boolean',
        'price' => 'decimal:2',
        'sold_at' => 'datetime',
    ];

    // Relationships
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'car_features');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'user_favorites');
    }

    public function inquiries()
    {
        return $this->hasMany(CarInquiry::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    // Scopes
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Helper method
    public function incrementViews()
    {
        $this->increment('view_count');
    }
}
