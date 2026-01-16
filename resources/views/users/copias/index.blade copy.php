@extends('layouts.admin')

@section('content')
<h2>Listar Usuários</h2>

<x-alert />
@can('create-user')
<a href="{{ route('users.create') }}">Cadastrar Usuário</a><br>
@endcan
<a href="{{ route('home') }}">Inicio</a><br>

{{-- Listar Usuarios --}}
@forelse ($users as $user)
ID: {{ $user->id }}<br>
Nome: {{ $user->name }}<br>
Email: {{ $user->email }}<br>
Status: {{ $user->status->name }}<br>
Papel: {{ $user->getRoleNames()->implode(', ') ?: '-' }}<br>
<a href="{{ route('users.show', ['user' => $user->id]) }}">Visualizar</a><br>
<a href="{{ route('users.edit', ['user' => $user->id]) }}">Editar</a><br>

<form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
    @csrf
    @method('delete')

    <button type="submit"
        onclick="return confirm('Tem certeza que deseja excluir o usuário {{ $user->name }} ?')">Apagar</button>
</form>
<hr>
@empty
<p>Não existem usuários cadastrados.</p>
@endforelse
{{ $users->links() }}
@endsection