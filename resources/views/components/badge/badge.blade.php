@props([
    'type' => 'default',
])

@php
    $classes = match ($type) {
        'active' => 'bg-green-100 text-green-700',
        'inactive' => 'bg-red-100 text-red-700',
        'expired' => 'bg-gray-200 text-gray-700',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<span class="px-2 py-1 rounded text-sm {{ $classes }}">
    {{ $slot }}
</span>
