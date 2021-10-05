<x-app-layout>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">{{ $project->title }}</h1>
    </div>

    <p class="my-4">{{ $project->description }}</p>

    <a href="/projects" class="text-blue-400 hover:text-blue-500">Back</a>
</x-app-layout>
