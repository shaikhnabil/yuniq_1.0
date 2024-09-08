@extends('admin.dashboard')
@push('title') Admin Register @endpush
@section('main')
    <div class="container">
        <div class="d-flex flex-column justify-content-center align-items-center w-50 mx-auto pt-3 mb-4">
            <div class="w-100 mt-4 px-4 py-3 bg-white shadow-sm rounded-lg sm-w-100 rounded">
                <h3 class="fw-bold fs-3 text-center">Admin Register</h3>
                <form method="POST" action="{{ route('admin.register') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="form-control" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="form-control" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="d-flex align-items-center justify-content-end mt-4">
                        <a class="text-decoration-underline text-sm text-muted hover-text-dark rounded" href="{{ route('admin.login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-primary-button class="btn btn-primary ms-3">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
