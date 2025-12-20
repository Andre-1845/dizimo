<div class="content-box-btn flex gap-2">

    {{-- LISTAR --}}
    @if ($list && (!$canList || auth()->user()->can($canList)))
        <a href="{{ $list }}" class="btn-primary align-icon-btn" title="{{ $listLabel }}">
            @include('components.icons.list')
            <span class="hide-name-btn">{{ $listLabel }}</span>
        </a>
    @endif

    {{-- EDITAR --}}
    @if ($edit && (!$canEdit || auth()->user()->can($canEdit)))
        <a href="{{ $edit }}" class="btn-warning align-icon-btn" title="Editar">
            @include('components.icons.edit')
            <span class="hide-name-btn">Editar</span>
        </a>
    @endif

    {{-- SENHA --}}
    @if ($password && (!$canPassword || auth()->user()->can($canPassword)))
        <a href="{{ $password }}" class="btn-info align-icon-btn" title="Senha">
            @include('components.icons.key')
            <span class="hide-name-btn">Senha</span>
        </a>
    @endif

    {{-- APAGAR --}}
    @if ($delete && (!$canDelete || auth()->user()->can($canDelete)))
        <form action="{{ $delete }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn-danger align-icon-btn" title="Apagar"
                onclick="return confirm('{{ $deleteConfirm }}')">
                @include('components.icons.trash')
                <span class="hide-name-btn">Apagar</span>
            </button>
        </form>
    @endif

</div>
