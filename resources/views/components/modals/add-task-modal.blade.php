@props(['project'])

<x-modals.modal
    title="Add Task"
    openEvent="open-add-task-modal"
    closeEvent="close-add-task-modal"
>
    <form
        x-data="{
            form: {
                body: '',
            },

            errors: {}
        }"

        @submit.prevent="
            axios.post('{{ $project->path() }}/tasks', form)
                .then(res => location.reload())
                .catch(err => errors = err.response.data.errors)
        "
    >
        <div class="flex flex-col">
            <div>
                <label for="task__body">Task body</label>
                <x-controls.input
                    type="text"
                    name="body"
                    id="task__body"
                    x-model="form.body"
                    ::class="{ 'border-red-500': errors.body }"
                    data-autofocus="open-add-task-modal"
                    required
                />
                <template x-if="errors.body">
                    <div class="text-red-500" x-text="errors.body"></div>
                </template>
            </div>

            <div class="mt-6 self-end space-x-2">
                <x-controls.button
                    outlined
                    @click="$dispatch('close-add-task-modal')"
                >
                    Cancel
                </x-controls.button>

                <x-controls.button type="submit">Add task</x-controls.button>
            </div>
        </div>
    </form>
</x-modals.modal>
