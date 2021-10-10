@props(['outlined' => false])

@php
    $outlinedClasses = 'text-blue';
    $primaryClasses = 'bg-blue hover:bg-blue-dark text-white';
@endphp

<button
    {{
        $attributes->merge([
            'class' => 'rounded-lg px-8 py-2 rounded-lg border border-blue transition '
                .($outlined ? $outlinedClasses : $primaryClasses)
        ])
    }}
>
    {{ $slot }}
</button>
