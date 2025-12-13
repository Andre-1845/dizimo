@extends('layouts.admin')

@section('content')
    <h2>Listar Papeis</h2>

    <x-alert /><br>

    <a href="{{ route('home') }}">Inicio</a><br>
    <a href="{{ route('roles.create') }}">Cadastrar</a><br>

    @forelse ($roles as $role)
        ID: {{ $role->id }}<br>
        Papel: <strong>{{ $role->name }}</strong><br>
        Guard_name: {{ $role->guard_name }}<br>
        <a href="{{ route('roles.show', ['role' => $role->id]) }}">Visualizar</a><br>
        @can('index-role-permission')
            <a href="{{ route('role-permissions.index', ['role' => $role->id]) }}">Permissoes</a><br>
        @endcan
        @can('edit-role')
            <a href="{{ route('roles.edit', ['role' => $role->id]) }}">Editar</a><br>
        @endcan

        @can('destroy-role')
            <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="post">
                @csrf
                @method('delete')

                <button type="submit"
                    onclick="return confirm('Tem certeza que deseja excluir o papel {{ $role->name }} ?')">Apagar</button>
            </form>
        @endcan

        <hr>
    @empty
        Nenhum papel cadastrado.
    @endforelse
    {{ $roles->links() }}
@endsection
