@extends('car_template.base')

@section('title', 'Search Cars - Car Selling Website')

@section('content')
<section>
    <div class="container">
        @livewire('car.search-cars')
    </div>
</section>
@endsection
