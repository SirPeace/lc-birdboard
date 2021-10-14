<x-app-layout>
    <!-- Modals -->
    <x-modals.add-task-modal :project="$project" />
    <x-modals.edit-project-modal :project="$project" />
    <!-- Modals -->

    <x-slot name="sidebar">
        <x-activity.feed :project="$project" />
    </x-slot>

    <header x-data="{}" class="flex justify-between flex-col lg:flex-row lg:items-center mb-4 px-3 lg:px-0">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <span class="inline-block text-gray-400 mr-4 mb-4 lg:mb-0">
                <a href="/projects" class="hover:underline">My Projects</a> / {{ $project->title }}
            </span>

            <x-controls.primary-button
                @click="$dispatch('open-add-task-modal')"
                class="self-end lg:self-auto"
            >
                Add Task
            </x-controls.primary-button>
        </div>

        <div class="flex items-center">
            <div class="flex space-x-2">
                @foreach ($project->members as $member)
                    <x-user-avatar :user="$member"/>
                @endforeach

                <x-user-avatar :user="$project->owner"/>
            </div>

            <x-controls.primary-button
                @click="$dispatch('open-edit-project-modal')"
                class="ml-4"
            >
                Edit Project
            </x-controls.primary-button>
        </div>
    </header>

    <div class="flex flex-col lg:flex-row lg:-mx-3">
        <div class="lg:w-3/4 px-3 lg:mb-0 order-2 lg:order-none">
            <section class="mb-6">
                <h3 class="text-lg text-gray-400 mb-4">Tasks</h3>

                @forelse ($project->tasks as $task)
                    <x-cards.task-card class="mb-4" :task="$task" />
                @empty
                    <p>No tasks added yet.</p>
                @endforelse
            </section>

            <section>
                <h3 class="text-lg text-gray-400 mb-4">Notes</h3>

                <x-controls.live-input
                    textarea
                    :url="$project->path()"
                    method="PATCH"
                    field="notes"
                    :value="$project->notes"
                    class="rounded-lg bg-white p-3 shadow border-none w-full"
                    rows="10"
                    placeholder="Project notes here..."
                />
            </section>
        </div>

        <div class="lg:w-1/4 px-3 order-1 lg:order-none mb-10 lg:mb-0">
            <x-cards.project-card
                :title="$project->title"
                :description="$project->description"
            />
        </div>
    </div>
</x-app-layout>
