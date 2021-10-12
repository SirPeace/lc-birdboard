@props(['item'])

<div>
    {{ $item->user->name }} created the task:
    <p>
        <strong><q>{{ $item->subject->body }}</q></strong>
    </p>
</div>
