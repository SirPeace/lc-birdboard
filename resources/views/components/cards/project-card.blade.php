@props(['project', 'link' => false])

@php
    $project->description = strlen($project->description) >= 170
        ? substr($project->description, 0, 170).'…'
        : $project->description
@endphp

<x-cards.card
    {{ $attributes->merge(['class' => 'flex flex-col']) }}
    onclick="
        const link = '{{ $link }}' && '{{ $project->path() }}'

        if (link) location = link
    "
>
    <header class="flex border-l-primary-light border-l-6 mb-3 -mx-3">
        @if ($link)
            <a href="{{ $project->path() }}">
                <h2 class="flex-1 text-lg py-3 px-3">{{ $project->title }}</h2>
            </a>
        @else
            <h2 class="flex-1 text-lg py-3 px-3">{{ $project->title }}</h2>
        @endif
    </header>

    <p class="px-2 text-muted">{{ $project->description }}</p>

    @can('manage', $project)
        <footer class="flex-1 flex items-end justify-end mt-4">
            <form action="{{ $project->path() }}" method="POST">
                @csrf
                @method("DELETE")

                <button type="submit" class="hover:underline">Delete</button>
            </form>
        </footer>
    @endcan
</x-cards.card>
