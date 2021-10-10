<x-app-layout>
    <!-- Modals -->
    <x-modals.create-project-modal />
    <!-- Modals -->

    <x-slot name="sidebar">
        <h3 class="text-xl text-gray-400 mb-4">Latest Activity</h3>

        <ul>
            <li>No activity is present yet...</li>
        </ul>
    </x-slot>

    <div class="flex justify-between items-end mb-6 px-3 lg:px-0">
        <span class="text-gray-400">My projects</span>
        <x-controls.primary-button x-data="{}" @click="$dispatch('open-create-project-modal')">
            Create Project
        </x-controls.primary-button>
    </div>

    <div class="lg:flex lg:flex-wrap lg:-mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <x-cards.project-card
                    :link="'/projects/'.$project->id"
                    :description="
                        strlen($project->description) >= 170
                            ? substr($project->description, 0, 170).'…'
                            : $project->description
                    "
                    :title="$project->title"
                    class="h-full hover:shadow-lg transition cursor-pointer"
                />
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
</x-app-layout>
