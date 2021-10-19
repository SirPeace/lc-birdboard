@props(['textarea' => false, 'value' => null])

@if (!$textarea)
    <input
        value="{{ $value }}"
        {{
            $attributes->merge([
                'class' => 'px-4 py-3 rounded bg-input border border-input w-full focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-30'
            ])
        }}
    >
@else
    <textarea
        {{
            $attributes->merge([
                'class' => 'px-4 py-3 rounded bg-input border border-input w-full focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-30'
            ])
        }}
    >{{ $value }}</textarea>
@endif
