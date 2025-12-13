@extends('layouts.login')

@section('content')
    <h3>Nova Senha</h3>

    <x-alert />
    {{-- {{ dd($token) }} --}}
    <form action="{{ route('password.update') }}" method="post">
        @csrf
        @method('post')

        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email">Email: </label>
        <input type="email" name="email" id="email" placeholder="Digite o email" value="{{ old('email', $email) }}"
            readonly><br><br>

        <label for="password">Senha: </label>
        <input type="password" name="password" id="password" placeholder="Digite a senha"><br><br>

        <label for="">Confirmar Senha: </label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a Senha"><br><br>
        {{-- {{ dd($token) }} --}}
        <button type="submit">Cadastrar</button><br><br>

    </form>

    <a href="{{ route('login') }}">LOGIN</a><br>
@endsection
