@props(['outlined' => false])

@php
    $outlinedClasses = 'text-primary';
    $primaryClasses = 'bg-primary hover:bg-primary-dark text-white';
@endphp

<button
    {{
        $attributes->merge([
            'type' => 'button',
            'class' => 'rounded-lg px-8 py-2 rounded-lg border border-primary inline-flex items-center font-semibold text-sm tracking-widest focus:outline-none focus:ring ring-primary ring-opacity-30 disabled:opacity-25 transition ease-in-out duration-150 '
                .($outlined ? $outlinedClasses : $primaryClasses)
        ])
    }}
>
    {{ $slot }}
</button>
