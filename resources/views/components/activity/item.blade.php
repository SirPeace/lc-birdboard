@props(['item'])

<div {{ $attributes->merge(['class' => '']) }}>
    <x-dynamic-component :component="'activity.items.'.$item->slug" :item="$item" />

    <div class="text-sm text-gray-400">{{ $item->created_at->diffForHumans() }}</div>
</div>
