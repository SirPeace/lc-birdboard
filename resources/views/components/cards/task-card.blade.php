@props(['task'])

<x-cards.card {{ $attributes->merge() }}>
    <form action="{{ $task->path() }}" method="POST">
        @method('PATCH')
        @csrf

        <div class="flex items-center space-x-3">
            <x-controls.live-input
                :url="$task->path()"
                field="body"
                :value="$task->body"
                type="text"
                name="body"
                class="px-4 py-3 rounded border-none w-full"
            />

            <input
                type="checkbox"
                name="completed"
                value="1"
                onchange="this.form.submit()"
                @if ($task->completed) checked @endif
                class="rounded-xl border-2 border-primary hover:border-primary-dark transition cursor-pointer w-6 h-6 bg-input"
            >
        </div>
    </form>
</x-cards.card>
