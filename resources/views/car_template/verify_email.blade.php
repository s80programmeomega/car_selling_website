@extends('car_template.base')

@section('title', 'Verify Email - Car Selling Website')

@section('content')
<div class="container">
    <div class="card p-large my-large">
        <h2>Verify Your Email Address</h2>
        <div class="my-medium">
            Before proceeding, please check your email for a verification link.
            If you did not receive the email,
            <form method="POST" action="" class="inline-flex">
                <button type="submit" class="btn-link">click here to request another</button>
                .
            </form>
        </div>

        <div>
            <form class="inline" method="POST" action="">
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
        </div>
    </div>
</div>
@endsection
