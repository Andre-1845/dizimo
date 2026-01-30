<table class="table">
    <thead>
        <tr class="table-row-header">
            @foreach ($headers as $header)
                <th class="table-header {{ $header['class'] ?? '' }}">
                    {{ $header['label'] }}
                </th>
            @endforeach
            <th class="table-header center w-20 whitespace-nowrap">Ação</th>
        </tr>
    </thead>

    <tbody class="text-sm">
        @forelse ($items as $item)
            <tr class="table-row-body">
                @foreach ($columns as $column)
                    <td class="table-body {{ $column['class'] ?? '' }}">
                        {!! $column['value']($item) !!}
                    </td>
                @endforeach

                <td class="table-body text-center">
                    @can($permission)
                        <form method="POST" action="{{ route($confirmRoute, $item) }}"
                            onsubmit="return confirm('{{ $confirmMessage ?? 'Confirmar este registro?' }}')">
                            @csrf
                            @method('PATCH')

                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                Confirmar
                            </button>
                        </form>
                    @else
                        —
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($columns) + 1 }}" class="px-4 py-4 text-center text-gray-500">
                    {{ $emptyMessage ?? 'Nenhum registro pendente.' }}
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
