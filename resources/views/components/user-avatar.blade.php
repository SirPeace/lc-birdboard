@props(['user'])

<img
    src="{{ gravatar_url($user->email) }}"
    alt="{{ $user->name }}'s avatar"
    class="rounded-full w-10"
    width="40"
    {{ $attributes->merge() }}
>
