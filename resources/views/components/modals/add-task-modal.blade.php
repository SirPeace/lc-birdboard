@props(['project'])

<x-modals.modal
    title="Add Task"
    openEvent="open-add-task-modal"
    closeEvent="close-add-task-modal"
>
    <form action="{{ $project->path() }}/tasks" method="POST">
        @csrf
        <div class="flex flex-col">
            <div>
                <label for="task__body">Task description</label>
                <x-controls.input
                    type="text"
                    name="body"
                    :value="old('task')"
                    id="task__body"
                />
                @error('body') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-6 self-end space-x-2">
                <x-controls.primary-button
                    type="button"
                    outlined
                    @click="$dispatch('close-add-task-modal')"
                >
                    Cancel
                </x-controls.primary-button>

                <x-controls.primary-button type="submit">Add task</x-controls.primary-button>
            </div>
        </div>
    </form>
</x-modals.modal>
