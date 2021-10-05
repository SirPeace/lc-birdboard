<x-app-layout>
    <header class="flex flex-col lg:flex-row lg:items-center mb-4 px-3 lg:px-0">
        <span class="inline-block text-gray-400 mr-4 mb-4 lg:mb-0">
            <a href="/projects" class="hover:underline">My Projects</a> / {{ $project->title }}
        </span>

        <a href="#" class="text-white bg-blue px-8 py-2 rounded-xl hover:bg-blue-dark transition self-end lg:self-auto">Add Task</a>
    </header>

    <div class="flex flex-col lg:flex-row lg:-mx-3">
        <div class="lg:w-3/4 px-3 lg:mb-0 order-2 lg:order-none">
            <section class="mb-6">
                <h3 class="text-lg text-gray-400 mb-4">Tasks</h3>

                <x-card>Lorem ipsum</x-card>
            </section>

            <section>
                <h3 class="text-lg text-gray-400 mb-4">Notes</h3>

                <x-card>Lorem ipsum</x-card>
            </section>
        </div>

        <div class="lg:w-1/4 px-3 order-1 lg:order-none mb-10 lg:mb-0">
            <x-project-card
                :title="$project->title"
                :description="$project->description"
            />
        </div>
    </div>
</x-app-layout>
