@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white text-center rounded-top">
                    <h4 class="text-black" class="mb-0">{{ __('Welcome Back') }}</h4>
                    <small class="text-black">{{ __('Please login to continue') }}</small>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="username" class="form-label">{{ __('Username') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope-fill text-primary"></i></span>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            </div>
                            @error('username')
                            <small class="text-danger">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock-fill text-primary"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                            </div>
                            @error('password')
                            <small class="text-danger">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg active">{{ __('Login') }}</button>
                        </div>
                        <div class="text-center mt-3">
                            <p class="mb-0">{{ __('Don\'t have an account?') }}
                                <a href="{{ route('register') }}" class="text-primary fw-bold">{{ __('Sign Up') }}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
