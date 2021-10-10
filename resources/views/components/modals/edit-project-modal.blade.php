@props(['project'])

<x-modals.modal
    title="Edit project"
    openEvent="open-edit-project-modal"
    closeEvent="close-edit-project-modal"
>
    <form action="{{ $project->path() }}" method="POST">
        @csrf
        @method("PATCH")

        <div class="flex flex-col">
            <div class="space-y-3">
                <div>
                    <label for="project__title">Title</label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') ?? $project->title }}"
                        class="px-4 py-3 rounded bg-gray-50 border-none w-full"
                        id="project__title"
                    >
                </div>
                <div>
                    <label for="project__description">Description</label>
                    <input
                        type="text"
                        name="description"
                        value="{{ old('description') ?? $project->description }}"
                        class="px-4 py-3 rounded bg-gray-50 border-none w-full"
                        id="project__description"
                    >
                </div>
            </div>

            <div class="mt-6 self-end space-x-2">
                <x-controls.primary-button
                    type="button"
                    outlined
                    @click="$dispatch('close-edit-project-modal')"
                >
                    Cancel
                </x-controls.primary-button>

                <x-controls.primary-button type="submit">Edit project</x-controls.primary-button>
            </div>
        </div>
    </form>
</x-modals.modal>
