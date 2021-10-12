@props(['item'])

<div>
    {{ $item->user->name }} incompleted the task:
    <p>
        <strong><q>{{ $item->subject->body }}</q></strong>
    </p>
</div>
