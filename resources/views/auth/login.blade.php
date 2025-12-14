@extends('layouts.login')

@section('content')
    <h1 class="title-login">Área Restrita</h1>

    <x-alert />

    <form class="form-group-login" action="{{ route('login.process') }}" method="post">
        @csrf
        @method('POST')

        <!-- Campo e-mail -->
        <div class="form-group-login">
            <label for="email" class="form-label-login">E-mail</label>
            <input class="form-input-login" type="email" name="email" id="email" value="{{ old('email') }}"
                placeholder="Digite o e-mail" />
        </div>

        <!-- Campo senha -->
        <div class="form-group-login">
            <label for="password" class="form-label-login">Senha</label>
            <input class="form-input-login" type="password" name="password" id="password" value="{{ old('password') }}"
                placeholder="Digite a senha" />
        </div>


        <!-- Link para recuperação de senha e botão de login -->
        <div class="btn-group-login">
            <a href="{{ route('password.request') }}" class="link-login">Esqueceu a senha?</a>
            <button type="submit" class="btn-danger">Acessar</button>

        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="link-login">Criar nova conta!</a>
        </div>

    </form>
    <br>
    {{-- <a href="{{ route('home') }}">Inicio</a><br><br> --}}
    {{-- <a href="{{ route('password.request') }}">Esqueceu a senha ?</a><br><br>
    Não é cadastrado ? <a href="{{ route('register') }}">Inscrever-se</a> --}}
@endsection
