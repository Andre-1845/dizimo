@props(['paginator'])

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mt-4">

    {{-- Informação de registros --}}
    <div class="text-sm text-gray-600">

        @if ($paginator->total() > 0)
            Mostrando
            <span class="font-semibold">{{ $paginator->firstItem() }}</span>
            –
            <span class="font-semibold">{{ $paginator->lastItem() }}</span>
            de
            <span class="font-semibold">{{ $paginator->total() }}</span>
            registros
        @else
            Nenhum registro encontrado
        @endif

    </div>


    <div class="flex items-center gap-4">

        {{-- Seletor de quantidade --}}
        <form method="GET" class="flex items-center gap-2">

            @foreach (request()->except(['per_page', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <span class="text-sm text-gray-600">Mostrar</span>

            <select name="per_page" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">

                @foreach ([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}"
                        {{ request('per_page', session('per_page', 10)) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach

            </select>

            <span class="text-sm text-gray-600">por página</span>

        </form>

        {{-- Links de paginação --}}
        {{ $paginator->links() }}

    </div>

</div>
