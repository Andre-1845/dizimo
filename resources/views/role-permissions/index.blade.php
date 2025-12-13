@extends('layouts.admin')

@section('content')
    <h2>Permissoes de {{ $role->name }}</h2>

    <x-alert /><br>

    <a href="{{ route('home') }}">Inicio</a><br>
    <a href="{{ route('roles.index') }}">Listar papeis</a><br>

    @forelse ($permissions as $permission)
        ID: {{ $permission->id }}<br>
        Permissao: <strong>{{ $permission->name }}</strong><br>

        @if (in_array($permission->id, $rolePermissions ?? []))
            <a href="{{ route('role-permissions.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
                <span style="color:#086">Liberado</span>
            </a>
        @else
            <a href="{{ route('role-permissions.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
                <span style="color:#f00">Bloqueado</span>
            </a>
        @endif
        {{-- <a href="{{ route('roles.show', ['role' => $role->id]) }}">Visualizar</a><br>
        <a href="{{ route('role-permissions.index', ['role' => $role->id]) }}">Permissoes</a><br>
        <a href="{{ route('roles.edit', ['role' => $role->id]) }}">Editar</a><br>

        <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="post">
            @csrf
            @method('delete')

            <button type="submit"
                onclick="return confirm('Tem certeza que deseja excluir o papel {{ $role->name }} ?')">Apagar</button>
        </form> --}}
        <hr>
    @empty
        Nenhum papel cadastrado.
    @endforelse
    {{-- {{ $permissions->links() }} --}}
@endsection
