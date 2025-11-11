@extends('car_template.base')

@section('title', 'Password Reset - Car Selling Website')

@section('content')
<div class="container-small page-login">
    <div class="flex" style="gap: 5rem">
        <div class="auth-page-form">
            <div class="text-center">
                <a href="/">
                    <img src="/img/logoipsum-265.svg" alt="" />
                </a>
            </div>
            <h1 class="auth-page-title">Request Password Reset</h1>

            <form action="" method="post">
                <div class="form-group">
                    <input type="email" placeholder="Your Email" />
                </div>

                <button class="btn btn-primary btn-login w-full">
                    Request password reset
                </button>

                <div class="login-text-dont-have-account">
                    Already have an account? -
                    <a href="/login.html"> Click here to login </a>
                </div>
            </form>
        </div>
        <div class="auth-page-image">
            <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
        </div>
    </div>
</div>
@endsection
