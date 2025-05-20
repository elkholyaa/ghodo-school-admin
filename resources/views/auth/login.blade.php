@extends('layouts.admin-guest')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <h2>{{ __('messages.login') }}</h2>
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
                <label for="email">{{ __('messages.email') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">{{ __('messages.password') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                </div>
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="remember_me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="remember_me">{{ __('messages.remember_me') }}</label>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-primary">
                            {{ __('messages.forgot_password') }} <i class="fas fa-question-circle"></i>
                        </a>
                    @endif
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('messages.login') }} <i class="fas fa-sign-in-alt"></i>
                    </button>
                </div>
            </div>
        </form>

        <p class="mt-3 text-center">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-center">
                    {{ __('messages.register') }} <i class="fas fa-user-plus"></i>
                </a>
            @endif
        </p>
    </div>
</div>
@endsection
