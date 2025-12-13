@extends('layouts.admin')

@section('content')
    <h2>Listar Status</h2>

    <x-alert />
    <br>
    <a href="{{ route('statuses.create') }}">Cadastrar Status</a><br>
    <a href="{{ route('home') }}">Inicio</a><br>

    {{-- Listar status --}}

    @forelse ($status as $item)
        ID: {{ $item->id }}<br>
        Status: {{ $item->name }}<br>
        <a href="{{ route('users.list', ['status' => $item->id]) }}">Usuários</a><br>
        <hr>
    @empty
        Nenhum item cadastrado
    @endforelse
@endsection
