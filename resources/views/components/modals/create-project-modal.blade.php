<x-modals.modal
    title="Create Project"
    openEvent="open-create-project-modal"
    closeEvent="close-create-project-modal"
>
    <form action="/projects" method="POST">
        @csrf

        <div class="flex flex-col">
            <div class="space-y-3">
                <div>
                    <label for="create-project-form__title">Title</label>
                    <input
                        type="text"
                        name="title"
                        id="create-project-form__title"
                        class="w-full rounded border-1 border-gray-300"
                        value="{{ old('title') }}"
                    >
                    @error('title') <div class="text-red-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label for="create-project-form__descrpition">Descrpition</label>
                    <textarea
                        name="description"
                        id="create-project-form__descrpition"
                        class="w-full rounded border-1 border-gray-300"
                        rows="5"
                    >{{ old('description') }}</textarea>
                    @error('description') <div class="text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-6 self-end space-x-2">
                <x-controls.primary-button
                    type="button"
                    outlined
                    @click="$dispatch('close-create-project-modal')"
                >
                    Cancel
                </x-controls.primary-button>

                <x-controls.primary-button type="submit">Create project</x-controls.primary-button>
            </div>
        </div>
    </form>
</x-modals.modal>
