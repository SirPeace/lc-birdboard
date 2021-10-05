<x-app-layout>
    <header class="flex items-center mb-4">
        <span class="text-gray-400 mr-4">
            <a href="/projects" class="hover:underline">My Projects</a> / {{ $project->title }}
        </span>

        <a href="/projects/create" class="text-white bg-blue px-8 py-2 rounded-xl hover:bg-blue-dark transition">Add Task</a>
    </header>

    <div class="flex -mx-3">
        <div class="w-3/4 px-3">
            <section class="mb-6">
                <h3 class="text-lg text-gray-400 mb-4">Tasks</h3>

                <x-card>Lorem ipsum</x-card>
            </section>

            <section>
                <h3 class="text-lg text-gray-400 mb-4">Notes</h3>

                <x-card>Lorem ipsum</x-card>
            </section>
        </div>

        <div class="w-1/4 px-3">
            <x-project-card
                :title="$project->title"
                :description="$project->description"
            />
        </div>
    </div>
</x-app-layout>
