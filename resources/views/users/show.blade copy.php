@extends('layouts.admin')

@section('content')
    <h2>Detalhes do Usuário</h2>
    <br>

    <x-alert />

    <br>
    <a href="{{ route('users.edit', ['user' => $user->id]) }}">Editar</a><br>
    <a href="{{ route('users.edit_password', ['user' => $user->id]) }}">Editar Senha</a><br>
    <a href="{{ route('home') }}">Inicio</a><br><br>

    {{-- Listar registro --}}


    ID: {{ $user->id }}<br>
    Nome: {{ $user->name }} <br>
    Email: {{ $user->email }} <br>
    Status: {{ $user->status->name }}<br>
    Papel: {{ $user->getRoleNames()->implode(', ') ?: '-' }}<br>
    {{-- Carbon é uma biblioteca Laravel usada para o format --}}
    Criado: {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }} <br>
    Alterado: {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }} <br>
@endsection
