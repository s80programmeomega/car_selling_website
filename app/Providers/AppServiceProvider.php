<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\City;
use App\Models\Maker;
use App\Models\State;
use App\Observers\CarObserver;
use App\Observers\CityObserver;
use App\Observers\MakerObserver;
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


        CarModel::observe(CarObserver::class);

        City::observe(CityObserver::class);

        // Automatically eager load relationships
        Model::automaticallyEagerLoadRelationships();
        // Model::preventsLazyLoading();
    }
}
