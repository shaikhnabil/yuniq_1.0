<section>
    <header>
        <h2 class="h4 text-dark font-weight-medium">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-muted small">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="form-group">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="form-control mt-1" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-danger small" :messages="$errors->get('name')" />
        </div>

        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="form-control mt-1" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2 text-danger small" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-muted small">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0 small text-primary">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success small">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="form-control" type="text" name="phone" :value="old('phone', $user->phone)"
                maxlength="15" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Image -->
        <div class="mb-3">
            <x-input-label for="image" :value="__('Profile Image')" />
            <x-text-input id="image" class="form-control" type="file" name="image" />
            <x-input-error :messages="$errors->get('image')" class="mt-2" />

            @if ($user->image)
                <div class="card-img-container d-flex overflow-x-auto mt-1">
                    <img src="{{ asset('storage/' . $user->image) }}"
                        class="card-img mx-2 border border-rounded rounded border" alt="Product Image"
                        style="width:40px;height:30px;">
                </div>
            @endif
        </div>

        <!-- Gender -->
        <div class="mb-3">
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="form-select">
                <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Date of Birth -->
        <div class="mb-3">
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <input id="dob" class="form-control" type="date" name="dob"
                value="{{old('dob', $user->dob)}}" />
            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mb-3">
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="form-control" type="text" name="address" :value="old('address', $user->address)" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="mb-3">
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" class="form-control" type="text" name="city" :value="old('city', $user->city)" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- State -->
        <div class="mb-3">
            <x-input-label for="state" :value="__('State')" />
            <x-text-input id="state" class="form-control" type="text" name="state" :value="old('state', $user->state)" />
            <x-input-error :messages="$errors->get('state')" class="mt-2" />
        </div>

        <!-- Country -->
        <div class="mb-3">
            <x-input-label for="country" :value="__('Country')" />
            <x-text-input id="country" class="form-control" type="text" name="country" :value="old('country', $user->country)" />
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
        </div>

        <!-- Zipcode -->
        <div class="mb-3">
            <x-input-label for="zipcode" :value="__('Zipcode')" />
            <x-text-input id="zipcode" class="form-control" type="number" name="zipcode" :value="old('zipcode', $user->zipcode)" />
            <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
        </div>

        <div class="d-flex align-items-center gap-4">
            <x-primary-button class="btn btn-primary mt-2">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted small mb-0">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

{{-- <section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section> --}}
