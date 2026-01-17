@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Perfil</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.admin') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('profile.show') }}" class="breadcrumb-link">Perfil</a>
                <span>/</span>
                <span>Editar senha</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Editar Senha</h3>

            <!-- Botoes (com icones)  -->
            <x-action-buttons :list="route('profile.show')" :password="route('profile.password.edit', $user)" can-list="profile.view" can-password="profile.password" />
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        <form action="{{ route('profile.password.update') }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="form-label">Nome *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="form-input" readonly>
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">E-mail *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="form-input" readonly>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-input"
                    placeholder="Senha com 6 caracteres, número e caracter especial">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirme a senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input"
                    placeholder="Repita a senha">
            </div>

            <div class="btn-md-div">
                <button type="submit" class="btn-success">
                    @include('components.icons.save')
                    Salvar
                </button>
            </div>

        </form>
    </div> <!-- FIM Content-Box  -->
@endsection
