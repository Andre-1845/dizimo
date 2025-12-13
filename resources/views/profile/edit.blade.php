@extends('layouts.admin')

@section('content')
    <h2>Editar Perfil</h2>
    <br>

    <x-alert />

    <br>
    <form action="{{ route('profile.update') }}" method="post">
        {{-- O CSRF impede o envio de dados de outras fontes. So aceita do próprio app --}}
        @csrf
        @method('PUT')

        <label for="">Nome: </label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" placeholder="Nome do usuário"
            required><br>
        <label for="">Email: </label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
            placeholder="Email do usuário" required><br>
        {{-- <label for="">Status: </label>
        <input type="text" name="status" id="status" value="{{ old('status', $user->status) }}"
            placeholder="Status do usuário" required><br> --}}


        <button type="submit">Salvar</button>
    </form>
@endsection
