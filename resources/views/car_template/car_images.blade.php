@extends('car_template.base')

@section('title', 'Car Images - Car Selling Website')

@section('content')
    @livewire('car.manage-images', ['car' => $car])
@endsection
