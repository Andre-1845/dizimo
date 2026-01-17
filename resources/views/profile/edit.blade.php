@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Perfil</h2>
            <x-smart-breadcrumb :items="[['label' => $user->name, 'url' => route('profile.show', $user)], ['label' => 'Editar']]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"><!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Editar Perfil</h3>
            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">
                <!-- Botoes (com icones)  -->
                <x-action-buttons :list="route('profile.show')" :list="route('profile.show', $user)" list-label="Perfil" :password="route('profile.password.edit', $user)"
                    can-list="profile.view" can-edit="profile.edit" can-password="profile.password" />
                <!-- Botoes (com icones)  -->
            </div>
        </div>

        <x-alert />

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <h3 class="font-semibold mb-3">Dados de acesso (usuário)</h3>

            <label class="form-label" for="user_name">Usuário: </label>
            <input class="form-input" type="text" name="user_name" value="{{ old('user_name', $user->name) }}">

            <label class="form-label" for="email">Email: </label>
            <input class="form-input" type="email" name="email" value="{{ old('email', $user->email) }}">


            @if ($user->member)
                <h3 class="font-semibold mb-3">Dados do membro</h3>

                <label class="form-label" for="member_name">Nome: </label>
                <input class="form-input" type="text" name="member_name"
                    value="{{ old('member_name', $user->member->name) }}">

                <label class="form-label" for="phone">Telefone: </label>
                <input class="form-input" type="text" name="phone" value="{{ old('phone', $user->member->phone) }}">
            @endif

            <div class="btn-md-div">
                <button class="btn-success">
                    @include('components.icons.save')
                    Salvar
                </button>
            </div>
        </form>

    </div>
@endsection
