@extends('layouts.admin')

@section('content')
    <h2>Editar Senha do Usuário</h2>
    <br>

    <x-alert />

    <br>
    <form action="{{ route('users.update_password', ['user' => $user->id]) }}" method="post">
        {{-- O CSRF impede o envio de dados de outras fontes. So aceita do próprio app --}}
        @csrf
        @method('PUT')

        <label for="">Senha: </label>
        <input type="password" name="password" id="password" placeholder="Senha" required><br>
        <label for="">Confirme a Senha: </label>
        <input type="password" name="password_confirmed" id="password_confirmed" placeholder="Repita a Senha" required><br>

        <button type="submit">Salvar</button>
    </form>
@endsection
