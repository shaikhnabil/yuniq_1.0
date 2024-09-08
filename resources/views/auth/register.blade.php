@push('title') Register @endpush
@extends('layouts.main')
@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10 col-12 pt-3 mb-4">
                <div class="w-100 mt-4 px-4 py-3 bg-white shadow-sm rounded-lg rounded">
                    <h3 class="fw-bold fs-3 text-center"><i class="bi bi-people"> Sign-up</i></h3>
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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

                        <!-- Phone -->
                        <div class="mb-3">
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" class="form-control" type="text" name="phone" :value="old('phone')"
                                maxlength="15" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <x-input-label for="image" :value="__('Profile Image')" />
                            <x-text-input id="image" class="form-control" type="file" name="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select id="gender" name="gender" class="form-select">
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-3">
                            <x-input-label for="dob" :value="__('Date of Birth')" />
                            <input id="dob" class="form-control" type="date" name="dob" :value="old('dob')" required />
                            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" class="form-control" type="text" name="address" :value="old('address')" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- City -->
                        <div class="mb-3">
                            <x-input-label for="city" :value="__('City')" />
                            <x-text-input id="city" class="form-control" type="text" name="city" :value="old('city')" />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>

                        <!-- State -->
                        <div class="mb-3">
                            <x-input-label for="state" :value="__('State')" />
                            <x-text-input id="state" class="form-control" type="text" name="state" :value="old('state')" />
                            <x-input-error :messages="$errors->get('state')" class="mt-2" />
                        </div>

                        <!-- Country -->
                        <div class="mb-3">
                            <x-input-label for="country" :value="__('Country')" />
                            <x-text-input id="country" class="form-control" type="text" name="country" :value="old('country')" />
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                        </div>

                        <!-- Zipcode -->
                        <div class="mb-3">
                            <x-input-label for="zipcode" :value="__('Zipcode')" />
                            <x-text-input id="zipcode" class="form-control" type="number" name="zipcode" :value="old('zipcode')" />
                            <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
                        </div>

                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between mt-4">
                            <a class="text-decoration-underline text-sm text-muted hover-text-dark rounded" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>

                            <x-primary-button class="btn btn-primary mt-3 mt-sm-0 ms-sm-3">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
