@props(['project'])

<x-modals.modal
    title="Edit project"
    openEvent="open-edit-project-modal"
    closeEvent="close-edit-project-modal"
>
    <form
        x-data="{
            form: {
                title: '{{ $project->title }}',
                description: '{{ $project->description }}'
            },

            errors: {}
        }"

        @submit.prevent="
            axios.patch('{{ $project->path() }}', form)
                .then(res => location.reload())
                .catch(err => errors = err.response.data.errors)
        "
    >
        <div class="flex flex-col">
            <div class="space-y-3">
                <div>
                    <label for="project__title">Title</label>
                    <x-controls.input
                        type="text"
                        name="title"
                        id="project__title"
                        x-model="form.title"
                        ::class="{ 'border-red-500': errors.title }"
                        data-autofocus="open-edit-project-modal"
                        required
                    />
                    <template x-if="errors.title">
                        <div class="text-red-500" x-text="errors.title"></div>
                    </template>
                </div>
                <div>
                    <label for="project__description">Description</label>
                    <x-controls.input
                        type="text"
                        name="description"
                        id="project__description"
                        x-model="form.description"
                        ::class="{ 'border-red-500': errors.description }"
                        required
                    />
                    <template x-if="errors.description">
                        <div class="text-red-500" x-text="errors.description"></div>
                    </template>
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
