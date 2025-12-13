@extends('layouts.admin')

@section('content')
    <h2>Detalhes do Papel</h2><br>

    <x-alert />
    <br>

    <a href="{{ route('home') }}">Inicio</a><br><br>
    <a href="{{ route('roles.edit', ['role' => $role->id]) }}">Editar</a><br><br>
    <a href="{{ route('role-permissions.index', ['role' => $role->id]) }}">Permissoes</a><br><br>

    ID: {{ $role->id }}<br>
    Papel: {{ $role->name }}<br>
    Guard Name: {{ $role->guard_name }}<br>
    {{-- Carbon é uma biblioteca Laravel usada para o format --}}
    Criado: {{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y H:i:s') }} <br>
    Alterado: {{ \Carbon\Carbon::parse($role->updated_at)->format('d/m/Y H:i:s') }} <br>
@endsection
