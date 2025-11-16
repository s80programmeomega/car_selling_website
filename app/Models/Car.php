<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;
use Yajra\Auditable\AuditableTrait;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;
    use AuditableTrait;
    use Searchable;

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
        return $this->hasMany(CarImage::class)->orderBy('sort_order');
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
    public function scopePublished(Builder $query)
    {
        return $query->where('published', true);
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('featured', true);
    }

    public function scopeAvailable(Builder $query)
    {
        return $query->where('status', 'available');
    }

    // Helper method
    public function incrementViews()
    {
        // update without raising updated event
        $this->updateQuietly(['view_count' => $this->view_count + 1]);
    }

    /**
     * Get the indexable data array for the model.
     * This defines what data gets sent to Typesense
     */
    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'maker' => $this->maker?->name ?? '',
            'model' => $this->model?->name ?? '',
            'year' => (int) $this->year,
            'price' => (float) $this->price,
            'mileage' => (int) $this->mileage,
            'description' => $this->description ?? '',
            'transmission' => $this->transmission ?? '',
            'color' => $this->color ?? '',
            'fuel_type' => $this->fuelType?->name ?? '',
            'car_type' => $this->carType?->name ?? '',
            'city' => $this->city?->name ?? '',
            'state' => $this->state?->name ?? '',
            'published' => $this->published,
            'featured' => $this->featured,
            'condition' => $this->condition ?? '',
        ];
    }

    /**
     * Modify the query used to retrieve models when making all searchable.
     * Only index published cars
     */
    public function makeAllSearchableUsing(Builder $query)
    {
        return $query->with(['maker', 'model', 'fuelType', 'carType', 'city', 'state']);
    }

    /**
     * Determine if the model should be searchable.
     * Only published cars should be in the search index
     */
    public function shouldBeSearchable()
    {
        return $this->published === true;
    }

    public static function searchCount($query = '')
    {
        return static::search($query)->raw()['found'] ?? 0;
    }

    protected static function booted()
    {
        static::saved(fn($model) => Cache::tags(['dropdowns'])->forget("models-maker-{$model->maker_id}"));
        static::deleted(fn($model) => Cache::tags(['dropdowns'])->forget("models-maker-{$model->maker_id}"));
    }

    // protected static function booted()
    // {
    //     // Clear cache when car is created
    //     static::created(function () {
    //         self::clearLatestCarsCache();
    //     });

    //     // Clear cache when car is updated
    //     static::updated(function ($car) {
    //         // Skip cache clear if ONLY view_count changed
    //         if ($car->wasChanged('view_count')) {
    //             return;  // Don't clear cache
    //         }

    //         // Clear cache for other changes
    //         self::clearLatestCarsCache();
    //     });

    //     // Clear cache when car is deleted
    //     static::deleted(function () {
    //         self::clearLatestCarsCache();
    //     });
    // }

    // /**
    //  * Clear all latest cars cache pages
    //  */
    // public static function clearLatestCarsCache()
    // {
    //     // Clear all search-related cache keys
    //     // This is aggressive but ensures fresh results
    //     // / Clear only latest cars pagination cache (first 50 pages)
    //     // Cache::flush();  // Or use tags if using Redis
    //     for ($page = 1; $page <= 50; $page++) {
    //         Cache::forget("latest-cars-page-{$page}");
    //     }
    // }
}
