@extends('layouts.admin')

@section('content')
    <h2>Editar Senha do Perfil</h2>
    <br>

    <x-alert />

    <br>
    <form action="{{ route('profile.update_password') }}" method="post">
        {{-- O CSRF impede o envio de dados de outras fontes. So aceita do próprio app --}}
        @csrf
        @method('PUT')

        <label for="password">Senha: </label>
        <input type="password" name="password" id="password" placeholder="Senha" required><br>
        <label for="password_confirmation">Confirme a Senha: </label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a Senha"
            required><br>

        <button type="submit">Salvar</button>
    </form>
@endsection
