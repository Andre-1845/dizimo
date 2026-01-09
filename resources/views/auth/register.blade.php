@extends('layouts.login')

@section('content')
    <h2 class="title-login">Cadastrar Novo Usuário</h2>

    <x-alert />

    <form class="form-group-login" action="{{ route('register.store') }}" method="post">
        @csrf
        @method('POST')

        <!-- Campo nome -->
        <div class="form-group-login">
            <label for="name" class="form-label-login">Nome</label>
            <input class="form-input-login" type="text" name="name" id="name" value="{{ old('name') }}"
                placeholder="Nome completo" />
        </div>

        <!-- Campo e-mail -->
        <div class="form-group-login">
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Melhor e-mail"
                class="form-input-login" />
        </div>

        <!-- Campo senha -->
        <div class="form-group-login">
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite a senha" class="form-input-login" />
        </div>
        <!-- Campo confirmar senha -->
        <div class="form-group-login">
            <label for="password" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a senha"
                class="form-input-login" />
        </div>

        <!-- Link para página de login e botão cadastrar novo usuário -->
        <div class="btn-group-login">
            <a href="{{ route('login') }}" class="link-login">Login</a>
            <a href="{{ route('site.home') }}" class="link-login">HomePage</a>
            <button type="submit" class="btn-primary-md">Cadastrar</button>
        </div>

    </form>
@endsection
