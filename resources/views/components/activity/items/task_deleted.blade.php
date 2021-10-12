@props(['item'])

<div>
    {{ $item->user->name }} deleted the task:
    <p>
        <strong><q>{{ $item->subject->body }}</q></strong>
    </p>
</div>
