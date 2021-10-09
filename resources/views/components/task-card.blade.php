@props(['task'])

<x-card {{ $attributes->merge(['class']) }}>
    <form action="{{ $task->path() }}" method="POST">
        @method('PATCH')
        @csrf

        <div class="flex items-center space-x-3">
            <x-live-input
                :url="$task->path()"
                method="PATCH"
                field="body"
                :value="$task->body"
                type="text"
                name="body"
                class="px-4 py-3 rounded bg-gray-50 border-none w-full"
            />

            <input
                type="checkbox"
                name="completed"
                value="1"
                onchange="this.form.submit()"
                @if ($task->completed) checked @endif
                class="rounded-xl border-2 border-blue hover:border-blue-dark transition cursor-pointer w-6 h-6"
            >
        </div>
    </form>
</x-card>
