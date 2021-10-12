@props(['title', 'description', 'link' => null])

<x-cards.card
    {{ $attributes->merge(['class']) }}
    onclick="
        const link = '{{ $link }}'

        if (link) location = link
    "
    class="flex flex-col"
>
    <div class="flex border-l-blue-light border-l-6 mb-3 -mx-3">
        @if ($link)
            <a href="{{ $link }}">
                <h2 class="flex-1 text-lg py-3 px-3">{{ $title }}</h2>
            </a>
        @else
            <h2 class="flex-1 text-lg py-3 px-3">{{ $title }}</h2>
        @endif
    </div>

    <p class="px-2 text-gray-400">{{ $description }}</p>

    @if (Route::is('projects.index') && $link)
        <div class="flex-1 flex items-end justify-end mt-4">
            <form action="{{ $link }}" method="POST">
                @csrf
                @method("DELETE")

                <button type="submit" class="hover:underline">Delete</button>
            </form>
        </div>
    @endif
</x-cards.card>
