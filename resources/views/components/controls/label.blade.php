@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-label']) }}>
    {{ $value ?? $slot }}
</label>
