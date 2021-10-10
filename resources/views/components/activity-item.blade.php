@props(['item'])

<div {{ $attributes->merge(['class' => '']) }}>
    @switch($item->slug)
        @case('created')
            You created the project
            @break

        @case('updated')
            You updated the project
            @break

        @case('task_created')
            You created the task
            @break

        @case('task_updated')
            You updated the task
            @break

        @case('task_deleted')
            You deleted the task
            @break
    @endswitch
    <div class="text-sm text-gray-400">{{ $item->created_at->diffForHumans() }}</div>
</div>
