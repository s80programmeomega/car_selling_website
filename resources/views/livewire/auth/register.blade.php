@extends('car_template.base')

@section('title', 'Signup - Car Selling Website')

@section('content')
<div class="container-small page-login">
    <div class="flex" style="gap: 5rem">
        <div class="auth-page-form">
            <div class="text-center">
                <a href="{{ route('index') }}">
                    <img src="/img/logoipsum-265.svg" alt="" />
                </a>
            </div>
            <h1 class="auth-page-title">Signup</h1>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="form-group">
                    <input type="text" name="username" placeholder="Your Username" value="{{ old('username') }}" required autofocus />
                    @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" value="{{ old('email') }}" required />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Your Password" required />
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Repeat Password" required />
                </div>

                <button type="submit" class="btn btn-primary btn-login w-full">Register</button>

                <div class="login-text-dont-have-account">
                    Already have an account? -
                    <a href="{{ route('login') }}"> Click here to login </a>
                </div>
            </form>
        </div>
        <div class="auth-page-image">
            <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
        </div>
    </div>
</div>
@endsection
