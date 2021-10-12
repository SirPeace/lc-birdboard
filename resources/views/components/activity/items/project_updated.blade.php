@props(['item'])

<div>
    @if (count($item->changes['after']) === 1)
        {{ $item->user->name }} changed the project {{ key($item->changes['after']) }}
    @else
        {{ $item->user->name }} updated the project
    @endif
</div>
