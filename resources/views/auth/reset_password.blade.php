@extends('layouts.login')

@section('content')
    <h3 class="title-login">Nova Senha</h3>

    <x-alert />

    <form class="form-group-login" action="{{ route('password.update') }}" method="post">
        @csrf
        @method('post')

        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Campo e-mail -->
        <div class="form-group-login">
            <label for="email" class="form-label-login">Email: </label>
            <input class="form-input-login" type="email" name="email" id="email" placeholder="Digite o email"
                value="{{ old('email', $email) }}" readonly><br><br>
        </div>

        <!-- Campo senha -->
        <div class="form-group-login">
            <label for="password" class="form-label-login">Senha: </label>
            <input class="form-input-login" type="password" name="password" id="password"
                placeholder="Digite a senha"><br><br>

            <!-- Campo confirmar senha -->
            <div class="form-group-login">
                <label class="form-label-login" for="password_confirmation">Confirmar Senha: </label>
                <input class="form-input-login" type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Repita a Senha"><br><br>
            </div>

            <div class="btn-group-login">

                <a href="{{ route('login') }}" class="link-login">LOGIN</a>
                <a href="{{ route('site.home') }}" class="link-login">HomePage</a>
                <button class="btn-primary" type="submit">Cadastrar</button>
            </div>
    </form>
@endsection
