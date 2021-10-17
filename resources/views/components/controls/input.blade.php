@props(['textarea' => false, 'value' => null])

@if (!$textarea)
    <input
        value="{{ $value }}"
        {{
            $attributes->merge([
                'class' => 'px-4 py-3 rounded bg-input border-none w-full'
            ])
        }}
    >
@else
    <textarea
        {{
            $attributes->merge([
                'class' => 'px-4 py-3 rounded bg-input border-none w-full'
            ])
        }}
    >{{ $value }}</textarea>
@endif
