<?php

use App\Http\Controllers\CarController;
use App\Livewire\Admin\CarModels;
use App\Livewire\Admin\CarTypes;
use App\Livewire\Admin\Cities;
use App\Livewire\Admin\Features as AdminFeatures;
use App\Livewire\Admin\FuelTypes;
use App\Livewire\Admin\Makers;
use App\Livewire\Admin\States;
use App\Livewire\Car\MyCars;
use App\Livewire\Car\MyFavorites;
use App\Livewire\Car\OldSearchCars;
use App\Livewire\Car\SearchCars;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Models\Car;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::view('admin', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication() &&
                    Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::resource('/', CarController::class)->only('index');

Route::get('/car/search', [CarController::class, 'search'])->name('car.search');

Route::resource('car', CarController::class);

Route::get('/car/{car}/images', function (Car $car) {
    return view('car_template.car_images', compact('car'));
})->name('car.images')->middleware('auth');

Route::get('admin/car/search', OldSearchCars::class)->name('car.oldsearch');

Route::get('/favorites', function () {
    return view('car_template.favorite_cars');
})->middleware('auth')->name('favorites');


// Admin routes for car-related data management
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/makers', Makers::class)->name('makers');
    Route::get('/car-models', CarModels::class)->name('car-models');
    Route::get('/car-types', CarTypes::class)->name('car-types');
    Route::get('/fuel-types', FuelTypes::class)->name('fuel-types');
    Route::get('/states', States::class)->name('states');
    Route::get('/cities', Cities::class)->name('cities');
    Route::get('/features', AdminFeatures::class)->name('features');
});

// Route::get('/my-cars', MyCars::class)->middleware('auth')->name('my-cars');

Route::view('/my-cars', 'car_template.my_cars')->middleware('auth')->name('my-cars');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // ... existing routes ...
    Route::get('/inquiries', \App\Livewire\Admin\CarInquiries::class)->name('inquiries');
    Route::get('/reviews', \App\Livewire\Admin\Reviews::class)->name('reviews');
});

// Add to car detail page routes
Route::get('/car/{car}/reviews', function (Car $car) {
    return view('car_template.car_reviews', compact('car'));
})->name('car.reviews');

Route::get('/car/{car}/inquiry', function (Car $car) {
    return view('car_template.car_inquiry', compact('car'));
})->name('car.inquiry');

