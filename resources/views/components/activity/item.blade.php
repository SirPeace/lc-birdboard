@props(['item'])

<div {{ $attributes->merge() }}>
    <x-dynamic-component :component="'activity.items.'.$item->slug" :item="$item" />

    <div class="text-sm text-muted">{{ $item->created_at->diffForHumans() }}</div>
</div>
