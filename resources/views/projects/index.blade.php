<x-app-layout>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">My projects</h1>
        <a href="/projects/create" class="text-blue-400 hover:text-blue-500">Create project</a>
    </div>

    <ul>
        @forelse ($projects as $project)
            <li>
                <a href="/projects/{{ $project->id }}" class="text-blue-400 hover:text-blue-500">{{ $project->title }}</a>
            </li>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </ul>
</x-app-layout>
