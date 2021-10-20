<x-modals.modal
    title="Create Project"
    openEvent="open-create-project-modal"
    closeEvent="close-create-project-modal"
    large
>
    <form
        action="/projects"
        method="POST"

        x-data="{
            form: {
                title: '',
                description: ''
            },

            tasks: [],

            errors: {},
        }"

        @submit.prevent="
            const formFields = {...form}

            axios.post('/projects', formFields)
                .then(res => {
                    const projectPath = res.data.data.path

                    Promise.all(
                        tasks.map(task => axios.post(`${projectPath}/tasks`, task))
                    ).then(
                        () => location = projectPath
                    )
                })
                .catch(error => errors = error.response.data.errors)
        "
    >
        <div class="flex flex-col">
            <div class="flex space-x-10">
                <div class="flex-1 space-y-3">
                    <div>
                        <x-controls.label for="create-project-form__title">Title</x-controls.label>
                        <x-controls.input
                            name="title"
                            id="create-project-form__title"
                            :value="old('title')"
                            ::class="{ 'border-red-500': errors.title }"
                            x-model="form.title"
                        />
                        <template x-if="errors.title">
                            <div class="text-red-600" x-text="errors.title"></div>
                        </template>
                    </div>

                    <div>
                        <x-controls.label for="create-project-form__description">Descrpition</x-controls.label>
                        <x-controls.input
                            textarea
                            :value="old('description')"
                            name="description"
                            id="create-project-form__description"
                            rows="5"
                            ::class="{ 'border-red-500': errors.description }"
                            x-model="form.description"
                        />
                        <template x-if="errors.description">
                            <div class="text-red-600" x-text="errors.description"></div>
                        </template>
                    </div>
                </div>

                <div class="flex-1">
                    <h4 class="text-lg mb-2">Need some tasks?</h4>

                    <ul class="">
                        <template x-for="task in tasks">
                            <x-controls.input type="text" placeholder="Add new task..." x-model="task.body" class="mb-2" />
                        </template>

                        <button
                            type="button"
                            class="flex space-x-2 hover:bg-hover transition w-full rounded p-2 focus:ring ring-primary ring-opacity-30"
                            @click="tasks.push({body: ''})"
                        >
                            <svg class="h-6 w-6 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <span>Add new task field</span>
                        </button>
                    </ul>
                </div>
            </div>

            <footer class="mt-6 self-end space-x-2">
                <x-controls.button
                    type="button"
                    outlined
                    @click="$dispatch('close-create-project-modal')"
                >
                    Cancel
                </x-controls.button>

                <x-controls.button type="submit">Create project</x-controls.button>
            </footer>
        </div>
    </form>
</x-modals.modal>
