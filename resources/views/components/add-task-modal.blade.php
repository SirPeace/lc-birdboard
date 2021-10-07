@props(['project'])

<x-modal
    title="Add Task"
    openEvent="open-add-task-modal"
    closeEvent="close-add-task-modal"
>
    <form action="{{ $project->path() }}/tasks" method="POST">
        @csrf
        <div class="flex flex-col">
            <input type="text" name="body" class="px-4 py-3 rounded bg-gray-50 border-none w-full" placeholder="New task...">

            <div class="mt-6 self-end space-x-2">
                <x-primary-button
                    type="button"
                    outlined
                    @click="$dispatch('close-add-task-modal')"
                >
                    Cancel
                </x-primary-button>

                <x-primary-button type="submit">Add Task</x-primary-button>
            </div>
        </div>
    </form>
</x-modal>
