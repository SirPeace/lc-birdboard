<x-app-layout>
    <div class="flex justify-between items-end mb-6 px-3 lg:px-0">
        <span class="text-gray-400">My projects</span>
        <a href="/projects/create" class="text-white bg-blue px-8 py-2 rounded-xl hover:bg-blue-dark transition">Add Project</a>
    </div>

    <div class="lg:flex lg:flex-wrap lg:-mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <x-project-card
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
