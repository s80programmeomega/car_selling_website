@extends('car_template.base')

@section('title', 'Edit Car')

@section('content')
    @livewire('car.edit-car', ['car' => $car])
@endsection
