@extends('layouts.login')

@section('content')
    <h1 class="title-login">Recuperar a Senha</h1>

    <x-alert />

    <form class="form-group-login" action="{{ route('password.email') }}" method="post">
        @csrf
        @method('POST')

        <!-- Campo e-mail -->
        <div class="form-group-login">
            <label for="email" class="form-label-login">E-mail</label>
            <input class="form-input-login" type="email" name="email" id="email"
                placeholder="Digite o e-mail cadastrado" />
        </div>


        <!-- Link para página de login e botão recuperar senha -->
        <div class="btn-group-login">
            <a href="{{ route('login') }}" class="link-login">Login</a>
            <button type="submit" class="btn-primary-md">Recuperar</button>
        </div>

        <!-- Criar Nova Conta -->
        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="link-login">Criar nova conta!</a>
        </div>

    </form>
@endsection
