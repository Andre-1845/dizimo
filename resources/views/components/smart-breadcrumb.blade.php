{{-- resources/views/components/smart-breadcrumb.blade.php --}}
@php
    // Adiciona o dashboard como primeiro item sempre
    $breadcrumbItems = [
        [
            'label' => $getDashboardLabel(),
            'url' => $getDashboardRoute(),
        ],
        ...$items, // Spread operator para adicionar os itens passados
    ];
@endphp

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="flex flex-wrap items-center space-x-2 text-sm text-gray-600">
        @foreach ($breadcrumbItems as $index => $item)
            <li class="flex items-center">
                @if ($index > 0)
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                @endif

                @if (isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-blue-600 transition-colors">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-gray-800 font-medium">
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
