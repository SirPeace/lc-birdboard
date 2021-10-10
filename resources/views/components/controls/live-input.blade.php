@props(['url', 'method', 'field', 'value' => null, 'textarea' => false])

@php
    $_method = $method;

    $method = strtolower($method);
    $method = $method !== 'post' && $method !== 'get'
        ? 'post'
        : $method;

    $requestLogic = sprintf(
        <<<JS
        if (window.requestTimeout) {
            clearTimeout(window.requestTimeout)
            window.requestTimeout = null
        }

        window.requestTimeout = setTimeout(() => {
            fetch('%s', {
                method: '%s',
                body: JSON.stringify({
                    '%s': this.value,
                    _method: '%s',
                    _token: document.querySelector('meta[name=csrf-token]').content,
                }),
                headers: [
                    ['Content-Type', 'application/json']
                ]
            })
        }, 500)
        JS,
        $url, $method, $field, $_method
    )
@endphp

@if ($textarea)
    <textarea
        {{ $attributes->merge() }}
        oninput="{{ $requestLogic }}"
    >{{ $value }}</textarea>
@else
    <input
        {{ $attributes->merge() }}
        value="{{ $value }}"
        oninput="{{ $requestLogic }}"
    >
@endif
