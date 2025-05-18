@extends('layouts.admin-guest')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <h2>{{ __('Login') }}</h2>
    </div>
    <div class="card-body">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="remember_me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="remember_me">{{ __('Remember me') }}</label>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-primary">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
                </div>
            </div>
        </form>

        <p class="mt-3 text-center">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-center">{{ __('Register a new membership') }}</a>
            @endif
        </p>
    </div>
</div>
@endsection
