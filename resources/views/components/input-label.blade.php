@props(['value'])

{{-- <label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label> --}}

<label {{ $attributes->merge(['class' => 'd-block mb-1 font-weight-medium text-secondary small']) }}>
    {{ $value ?? $slot }}
</label>
