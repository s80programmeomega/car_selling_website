@extends('car_template.base')

@section('title', 'Login - Car Selling Website')

@section('content')
<div class="container-small page-login">
    <div class="flex" style="gap: 5rem">
        <div class="auth-page-form">
            <div class="text-center">
                <a href="{{ route('index') }}">
                    <img src="/img/logoipsum-265.svg" alt="" />
                </a>
            </div>
            <h1 class="auth-page-title">Login</h1>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" value="{{ old('email') }}" required autofocus />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Your Password" required />
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2">Remember me</span>
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-right mb-medium">
                        <a href="{{ route('password.request') }}" class="auth-page-password-reset">Reset Password</a>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary btn-login w-full">Login</button>

                <div class="login-text-dont-have-account">
                    Don't have an account? -
                    <a href="{{ route('register') }}"> Click here to create one</a>
                </div>
            </form>
        </div>
        <div class="auth-page-image">
            <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
        </div>
    </div>
</div>
@endsection
