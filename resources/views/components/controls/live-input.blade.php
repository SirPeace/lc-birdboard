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
    <textarea
        {{ $attributes->merge() }}
        oninput="{{ $requestLogic }}"
    >{{ $value }}</textarea>
@else
    <input
        {{ $attributes->merge(['class' => 'bg-input']) }}
        value="{{ $value }}"
        oninput="{{ $requestLogic }}"
    >
@endif
