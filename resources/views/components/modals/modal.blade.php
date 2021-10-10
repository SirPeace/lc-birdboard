@props(['title', 'openEvent', 'closeEvent' => null])

<div
    x-cloak
    x-data="{ isOpen: false }"
    x-show="isOpen"
    {{ '@'.$openEvent }}.window="isOpen = true"
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
            class="fixed inset-0 bg-gray-700 bg-opacity-75 transition-opacity"
            aria-hidden="true"
        ></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            x-show.transition.opacity.duration.300ms="isOpen"
            @click.away="isOpen = false"
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
        >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="mt-3 text-center sm:mt-0 sm:text-left">
                    <h3 class="text-xl font-bold leading-6 font-medium text-gray-900" id="modal-title">
                        {{ $title }}
                    </h3>

                    <div class="my-4">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
