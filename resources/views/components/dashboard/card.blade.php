@props(['title', 'value', 'valueClass' => 'text-gray-800'])

<div class="bg-white rounded border shadow p-4">
    <p class="text-sm text-gray-500">{{ $title }}</p>

    <p class="text-xl font-bold {{ $valueClass }}">
        {{ $value }}
    </p>
</div>
