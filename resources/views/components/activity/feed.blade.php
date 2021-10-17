@props(['project' => null])

<div>
    <h3 class="text-xl text-muted mb-4">Latest Activity</h3>

    <ul class="space-y-3 text-sm">
        @if ($project)
            @foreach($project->activity as $item)
                <x-activity.item :item="$item" />
            @endforeach
        @else
            No activity yet...
        @endif
    </ul>
</div>
