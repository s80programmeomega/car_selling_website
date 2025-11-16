<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarInquiry;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\Feature;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Review;
use App\Models\State;
use App\Observers\CarImageObserver;
use App\Observers\CarInquiryObserver;
use App\Observers\CarModelObserver;
use App\Observers\CarObserver;
use App\Observers\CarTypeObserver;
use App\Observers\CityObserver;
use App\Observers\FeatureObserver;
use App\Observers\FuelTypeObserver;
use App\Observers\MakerObserver;
use App\Observers\ReviewObserver;
use App\Observers\StateObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
    */
    public function boot(): void
    {
        // Register car observer
        Car::observe(CarObserver::class);

        // Register maker observer
        Maker::observe(MakerObserver::class);

        // Regicter state observer
        State::observe(StateObserver::class);


        CarModel::observe(CarModelObserver::class);

        City::observe(CityObserver::class);

        CarImage::observe(CarImageObserver::class);

        CarInquiry::observe(CarInquiryObserver::class);

        Review::observe(ReviewObserver::class);

        CarType::observe(CarTypeObserver::class);
        FuelType::observe(FuelTypeObserver::class);
        Feature::observe(FeatureObserver::class);


        // Automatically eager load relationships
        Model::automaticallyEagerLoadRelationships();
        // Model::preventsLazyLoading();
    }
}
