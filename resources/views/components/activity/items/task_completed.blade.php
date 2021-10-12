@props(['item'])

<div>
    {{ $item->user->name }} completed the task:
    <p>
        <strong><q>{{ $item->subject->body }}</q></strong>
    </p>
</div>
