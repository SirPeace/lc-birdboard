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
            <span class="inline-block text-muted mr-4 mb-4 lg:mb-0">
                <a href="/projects" class="hover:underline">My Projects</a> / {{ $project->title }}
            </span>

            <x-controls.button
                @click="$dispatch('open-add-task-modal')"
                class="self-end lg:self-auto"
            >
                Add Task
            </x-controls.button>
        </div>

        <div class="flex items-center">
            <div class="flex space-x-2">
                @foreach ($project->members as $member)
                    <x-user-avatar :user="$member"/>
                @endforeach

                <x-user-avatar :user="$project->owner"/>
            </div>

            <x-controls.button
                @click="$dispatch('open-edit-project-modal')"
                class="ml-4"
            >
                Edit Project
            </x-controls.button>
        </div>
    </header>

    <div class="flex flex-col xl:flex-row xl:-mx-3">
        <div class="xl:w-2/3 px-3 xl:mb-0 order-2 xl:order-none">
            <section class="mb-6">
                <h3 class="text-lg mb-4 text-muted">Tasks</h3>

                @forelse ($project->tasks as $task)
                    <x-cards.task-card class="mb-4" :task="$task" />
                @empty
                    <p>No tasks added yet.</p>
                @endforelse
            </section>

            <section>
                <h3 class="text-lg text-muted mb-4">Notes</h3>

                <x-controls.live-input
                    textarea
                    :url="$project->path()"
                    field="notes"
                    :value="$project->notes"
                    class="rounded-lg bg-card p-3 shadow border-none w-full"
                    rows="10"
                    placeholder="Project notes here..."
                />
            </section>
        </div>

        <div class="xl:w-1/3 px-3 order-1 xl:order-none mb-10 xl:mb-0">
            <x-cards.project-card :project="$project" />

            @can('manage', $project)
                <x-cards.card class="mt-6">
                    <h3 class="text-lg mb-6">Invite user</h3>

                    <form action="{{ $project->path() }}/invitations" method="POST">
                        @csrf

                        <div class="mb-3">
                            <x-controls.input type="text" name="email" placeholder="Email" :value="old('email')" />
                            @error('email') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>

                        <x-controls.button type="submit">Invite user</x-controls.button>
                    </form>
                </x-cards.card>
            @endcan
        </div>
    </div>
</x-app-layout>
