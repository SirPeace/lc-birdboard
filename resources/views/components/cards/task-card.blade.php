@props(['task'])

@php
    $inputClasses = 'px-1 py-1 rounded border-none w-full';

    if ($task->completed) {
        $inputClasses .= ' line-through text-muted';
    }
@endphp

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
                class="{{ $inputClasses }}"
                :disabled="$task->completed"
            />

            <x-controls.checkbox
                name="completed"
                value="1"
                onchange="this.form.submit()"
                :checked="$task->completed"
                class="rounded-xl w-6 h-6"
            />
        </div>
    </form>
</x-cards.card>
