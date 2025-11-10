<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Search for cars based on various filters.
     */
    public function search(Request $request)
    {
        $cars = Car::published()
            ->when($request->maker_id, fn($q) => $q->where('maker_id', $request->maker_id))
            ->when($request->model_id, fn($q) => $q->where('model_id', $request->model_id))
            ->when($request->state_id, fn($q) => $q->where('state_id', $request->state_id))
            ->when($request->city_id, fn($q) => $q->where('city_id', $request->city_id))
            ->when($request->car_type_id, fn($q) => $q->where('car_type_id', $request->car_type_id))
            ->when($request->fuel_type_id, fn($q) => $q->where('fuel_type_id', $request->fuel_type_id))
            ->when($request->year_from, fn($q) => $q->where('year', '>=', $request->year_from))
            ->when($request->year_to, fn($q) => $q->where('year', '<=', $request->year_to))
            ->when($request->price_from, fn($q) => $q->where('price', '>=', $request->price_from))
            ->when($request->price_to, fn($q) => $q->where('price', '<=', $request->price_to))
            ->with(['maker', 'model', 'carType', 'fuelType', 'images', 'state', 'city'])
            ->paginate(12);

        return view('cars.search', compact('cars'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
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
        //
    }
}
