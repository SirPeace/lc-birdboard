@props(['user'])

<img
    src="{{ $user->gravatarUrl() }}"
    alt="{{ $user->name }}'s avatar"
    width="40"
    {{ $attributes->merge(['class' => 'rounded-full w-10']) }}
>
