@props(['title', 'openEvent', 'closeEvent' => null, 'large' => false ])

<div
    x-cloak
    x-data="{ isOpen: false }"
    x-show="isOpen"
    {{ '@'.$openEvent }}.window="
        isOpen = true

        $nextTick(() => {
            const autofocusElement = document.querySelector('[data-autofocus={{ $openEvent }}]')

            autofocusElement?.focus()
        })
    "
    {{ '@'.$closeEvent }}.window="isOpen = false"
    @keydown.escape.window="isOpen = false"

    class="fixed z-10 inset-0 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div
            x-show.transition.opacity.duration.300ms="isOpen"
            class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
            aria-hidden="true"
        ></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            x-show.transition.opacity.duration.300ms="isOpen"
            @click.away="isOpen = false"
            class="inline-block align-bottom bg-modal rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl @if (!$large) sm:!max-w-lg @endif sm:w-full"
        >
            <div class="bg-modal p-6">
                <header class="mb-8">
                    <h3 class="text-2xl font-bold font-medium text-center">
                        {{ $title }}
                    </h3>
                </header>

                <div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
