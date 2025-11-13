<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Search for cars based on various filters.
     */
    public function search(Request $request)
    {
        // $cars = Car::published()
        //     ->when($request->maker_id, fn($q) => $q->where('maker_id', $request->maker_id))
        //     ->when($request->model_id, fn($q) => $q->where('model_id', $request->model_id))
        //     ->when($request->state_id, fn($q) => $q->where('state_id', $request->state_id))
        //     ->when($request->city_id, fn($q) => $q->where('city_id', $request->city_id))
        //     ->when($request->car_type_id, fn($q) => $q->where('car_type_id', $request->car_type_id))
        //     ->when($request->fuel_type_id, fn($q) => $q->where('fuel_type_id', $request->fuel_type_id))
        //     ->when($request->year_from, fn($q) => $q->where('year', '>=', $request->year_from))
        //     ->when($request->year_to, fn($q) => $q->where('year', '<=', $request->year_to))
        //     ->when($request->price_from, fn($q) => $q->where('price', '>=', $request->price_from))
        //     ->when($request->price_to, fn($q) => $q->where('price', '<=', $request->price_to))
        //     ->with(['maker', 'model', 'carType', 'fuelType', 'images', 'state', 'city'])
        //     ->paginate(12);

        return view('car_template.car_search');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $latest_cars = Car::with(['maker', 'model', 'carType', 'fuelType', 'city', 'images'])
        // ->latest()
        // ->take(9)
        // ->get();
        $latest_cars = Car::where('published', true)
            ->latest()
            ->take(9)
            ->get();
        // $latest_cars->withRelationshipAutoloading();
        return view('car_template.home', compact('latest_cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('car_template.add_new_car');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        // Load all relationships
        // $car->load(['maker', 'model', 'carType', 'fuelType', 'state', 'city', 'images', 'features', 'owner']);


        // Get all features with car's features marked
        $allFeatures = Feature::all();
        $carFeatureIds = $car->features->pluck('id')->toArray();

        // Increment view count
        $car->incrementViews();

        return view('car_template.car_details', compact('car', 'allFeatures', 'carFeatureIds'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('car_template.edit_car', compact('car'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        try {
            DB::beginTransaction();

            // Delete all images from storage
            foreach ($car->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            // Delete car (cascade will delete images and relationships)
            $car->delete();

            DB::commit();

            session()->flash('message', 'Car deleted successfully.');
            return redirect()->route('car.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete car: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete car.');
            return back();
        }
    }

}
