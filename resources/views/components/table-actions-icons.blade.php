<td {{ $attributes->merge(['class' => 'table-body align-middle']) }}>
    <div class="flex items-center justify-center gap-2">

        {{-- VER --}}
        @if ($show)
            @can($canShow ?? 'view')
                <a href="{{ $show }}" title="Visualizar" class="btn-primary">
                    @include('components.icons.view')
                </a>
            @endcan
        @endif

        {{-- EDITAR --}}
        @if ($edit)
            @can($canEdit ?? 'update')
                <a href="{{ $edit }}" title="Editar" class="btn-warning">
                    @include('components.icons.edit')
                </a>
            @endcan
        @endif

        {{-- EXCLUIR --}}
        @if ($delete)
            @can($canDelete ?? 'delete')
                <form action="{{ $delete }}" method="POST" onsubmit="return confirm('{{ $confirm }}')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" title="Excluir" class="btn-danger">
                        @include('components.icons.trash')
                    </button>
                </form>
            @endcan
        @endif

    </div>
</td>
