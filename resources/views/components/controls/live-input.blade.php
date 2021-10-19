@props(['url', 'field', 'value' => null, 'textarea' => false])

@php
    $requestLogic = sprintf(
        <<<JS
        if (window.requestTimeout) {
            clearTimeout(window.requestTimeout)
            window.requestTimeout = null
        }

        window.requestTimeout = setTimeout(() => {
            axios.patch('%s', {
                '%s': this.value
            })
        }, 500)
        JS,
        $url, $field
    )
@endphp

@if ($textarea)
    <x-controls.input
        textarea
        :value="$value"
        {{ $attributes->merge() }}
        oninput="{{ $requestLogic }}"
    />
@else
    <x-controls.input
        {{ $attributes->merge() }}
        :value="$value"
        oninput="{{ $requestLogic }}"
    />
@endif
