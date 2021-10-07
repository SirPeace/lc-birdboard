@props(['task'])

<x-card {{ $attributes->merge(['class']) }}>
    <form action="{{ $task->path() }}" method="POST">
        @method('PATCH')
        @csrf

        <div class="flex items-center space-x-3">
            <input
                type="text"
                name="body"
                value="{{ $task->body }}"
                class="px-4 py-3 rounded bg-gray-50 border-none w-full"
                oninput="
                    // Update comment body as user stops typing for 500ms
                    if (window.ajaxTimeout) {
                        clearTimeout(window.ajaxTimeout)
                        window.ajaxTimeout = null
                    }

                    window.ajaxTimeout = setTimeout(() => {
                        fetch('{{ $task->path() }}', {
                            method: 'POST',
                            body: JSON.stringify({
                                body: this.value,
                                _method: 'PATCH',
                                _token: document.querySelector('meta[name=csrf-token]').content
                            }),
                            headers: [
                                ['Content-Type', 'application/json']
                            ]
                        })
                    }, 500)
                "
            >

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
