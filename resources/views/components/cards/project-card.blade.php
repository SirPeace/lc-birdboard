@props(['project'])

@php
    $project->description = strlen($project->description) >= 170
        ? substr($project->description, 0, 170).'…'
        : $project->description
@endphp

<x-cards.card
    {{ $attributes->merge(['class']) }}
    onclick="
        const link = '{{ $project->path() }}'

        if (link) location = link
    "
    class="flex flex-col"
>
    <header class="flex border-l-blue-light border-l-6 mb-3 -mx-3">
        @if ($project->link)
            <a href="{{ $project->link }}">
                <h2 class="flex-1 text-lg py-3 px-3">{{ $project->title }}</h2>
            </a>
        @else
            <h2 class="flex-1 text-lg py-3 px-3">{{ $project->title }}</h2>
        @endif
    </header>

    <p class="px-2 text-gray-400">{{ $project->description }}</p>

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
