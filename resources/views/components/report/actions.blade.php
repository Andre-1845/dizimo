@props([
    'csvRoute' => null,
    'pdfRoute' => null,
    'backRoute' => null,
    'params' => [],
])

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-6">

    {{-- EXPORTAÇÃO --}}
    <div>
        <p class="text-sm text-center font-semibold text-gray-600 mb-2">
            EXPORTAR
        </p>

        <div class="flex gap-3 justify-center md:justify-start">
            @if ($pdfRoute)
                <a href="{{ route($pdfRoute, $params) }}" class="btn-info inline-flex items-center justify-center">
                    PDF
                </a>
            @endif

            @if ($csvRoute)
                <a href="{{ route($csvRoute, $params) }}" class="btn-warning inline-flex items-center justify-center">
                    CSV
                </a>
            @endif
        </div>
    </div>

    {{-- MENU / AÇÕES --}}
    <div>
        <p class="text-sm text-center font-semibold text-gray-600 mb-2">
            MENU
        </p>

        <div class="flex gap-3 justify-center md:justify-end">
            @if ($backRoute)
                <a href="{{ route($backRoute, $params) }}" class="btn-primary inline-flex items-center justify-center">
                    Voltar
                </a>
            @endif

            {{ $slot }}
        </div>
    </div>

</div>
