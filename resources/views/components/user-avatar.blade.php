@props(['user'])

<img
    src="{{ gravatar_url($user->email) }}"
    alt="{{ $user->name }}'s avatar"
    width="40"
    {{ $attributes->merge(['class' => 'rounded-full w-10']) }}
>
