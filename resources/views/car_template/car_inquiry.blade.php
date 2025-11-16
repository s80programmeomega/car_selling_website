@extends('car_template.base')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Inquire About {{ $car->maker->name }} {{ $car->model->name }}</h1>
    @livewire('car.send-inquiry', ['car' => $car])
</div>
@endsection
