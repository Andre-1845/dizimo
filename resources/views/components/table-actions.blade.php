<td {{ $attributes->merge(['class' => 'align-middle']) }}>
    <div class="flex items-center justify-end gap-2">

        {{-- VER --}}
        @if ($show)
            @can($canShow ?? 'view')
                <a href="{{ $show }}" title="Visualizar" class="btn-secondary btn-sm flex items-center gap-1">
                    {{-- Ícone --}}
                    @include('components.icons.view')
                    <span>Ver</span>
                </a>
            @endcan
        @endif

        {{-- EDITAR --}}
        @if ($edit)
            @can($canEdit ?? 'update')
                <a href="{{ $edit }}" title="Editar" class="btn-warning btn-sm flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.121 2.121 0 1 1 3 3L7.5 18.85
                                         3 21l2.15-4.5L16.862 3.487Z" />
                    </svg>
                    <span>Editar</span>
                </a>
            @endcan
        @endif

        {{-- EXCLUIR --}}
        @if ($delete)
            @can($canDelete ?? 'delete')
                <form action="{{ $delete }}" method="POST" onsubmit="return confirm('{{ $confirm }}')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" title="Excluir" class="btn-danger btn-sm flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 7h12M9 7V4h6v3M10 11v6M14 11v6M5 7l1 13h12l1-13" />
                        </svg>
                        <span>Excluir</span>
                    </button>
                </form>
            @endcan
        @endif

    </div>
</td>
