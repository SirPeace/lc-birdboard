<x-app-layout>
    <!-- Modals -->
    <x-modals.create-project-modal />
    <!-- Modals -->

    <div class="flex justify-between items-end mb-6 px-3 lg:px-0">
        <span class="text-muted">My projects</span>
        <x-controls.primary-button x-data="{}" @click="$dispatch('open-create-project-modal')">
            Create Project
        </x-controls.primary-button>
    </div>

    <div class="lg:flex lg:flex-wrap lg:-mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <x-cards.project-card
                    link
                    :project="$project"
                    class="h-full hover:shadow-lg transition cursor-pointer"
                />
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
</x-app-layout>
