@props(['outlined' => false])

@php
    $outlinedClasses = 'text-primary';
    $primaryClasses = 'bg-primary hover:bg-primary-dark text-white';
@endphp

<button
    {{
        $attributes->merge([
            'class' => 'rounded-lg px-8 py-2 rounded-lg border border-primary transition '
                .($outlined ? $outlinedClasses : $primaryClasses)
        ])
    }}
>
    {{ $slot }}
</button>
