@extends('admin.dashboard')
@push('title') Admin Login @endpush
@section('main')
<div class="container">
    @if (session('status'))
        <x-alert :msg="session('status')"></x-alert>
    @endif
</div>

<div class="container">
    <div class="d-flex flex-column justify-content-center align-items-center w-100 w-md-75 w-lg-50 mx-auto pt-3">
        <div class="w-100 mt-4 px-4 py-3 bg-white shadow-sm rounded-lg sm-w-100 rounded">
            <h3 class="fw-bold fs-3 text-center">Admin Login</h3>
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="form-control mt-1 w-100" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4 mb-3">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="form-control mt-1 w-100" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <div class="d-flex flex-column align-items-center justify-content-end mt-4">
                    <x-primary-button class="btn btn-primary w-100">
                        {{ __('Log in') }}
                    </x-primary-button>

                    @if (Route::has('password.request'))
                        <a class="text-decoration-underline text-sm text-muted hover-text-dark rounded focus-outline-none focus-ring-2 focus-ring-offset-2 focus-ring-primary mt-3"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <a class="text-decoration-underline text-sm text-muted hover-text-dark rounded mt-3 d-block text-center"
                   href="{{ route('admin.register') }}">
                    {{ __('Not registered?') }}
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
