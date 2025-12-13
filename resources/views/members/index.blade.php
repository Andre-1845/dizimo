@extends('layouts.admin')

@section('title', 'Membros')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Membros</h1>

    <div class="bg-white p-6 rounded shadow">
        <p>Cadastro de membros em desenvolvimento.</p>
    </div>

    @if ($members->isEmpty())
        <p class="text-gray-500">Nenhum membro cadastrado.</p>
    @endif
@endsection
