<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Create project</h1>

    <form method="POST" action="/projects" class="space-y-4 max-w-lg flex flex-col">
        @csrf

        <div>
            <div>
                <label for="create-project-form__title">Title</label>
            </div>
            <input
                type="text"
                name="title"
                id="create-project-form__title"
                class="w-full rounded border-1 border-gray-300"
                value="{{ old('title') }}"
            >
            @error('title') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div>
            <div>
                <label for="create-project-form__descrpition">Descrpition</label>
            </div>
            <textarea
                name="description"
                id="create-project-form__descrpition"
                class="w-full rounded border-1 border-gray-300"
            >
                {{ old('description') }}
            </textarea>
            @error('description') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="pt-4">
            <button
                type="submit"
                class="bg-blue-400 hover:bg-blue-dark transition rounded px-3 py-2 text-white w-full"
            >
                Create
            </button>

            <a href="/projects" class="inline-block text-blue-400 hover:text-blue-dark mt-2">Cancel</a>
        </div>
    </form>
</x-app-layout>
