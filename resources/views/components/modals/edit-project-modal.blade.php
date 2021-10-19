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
                    <x-controls.input
                        type="text"
                        name="title"
                        :value="old('title') ?? $project->title"
                        id="project__title"
                    />
                    @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="project__description">Description</label>
                    <x-controls.input
                        type="text"
                        name="description"
                        :value="old('description') ?? $project->description"
                        id="project__description"
                    />
                    @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 self-end space-x-2">
                <x-controls.button
                    type="button"
                    outlined
                    @click="$dispatch('close-edit-project-modal')"
                >
                    Cancel
                </x-controls.button>

                <x-controls.button type="submit">Edit project</x-controls.button>
            </div>
        </div>
    </form>
</x-modals.modal>
