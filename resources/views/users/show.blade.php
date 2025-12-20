@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Usuários</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('users.index') }}" class="breadcrumb-link">Usuários</a>
                <span>/</span>
                <span>Visualizar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Detalhes</h3>

            <!-- Botoes (com icones)  -->
            <x-action-buttons :list="route('users.index')" :edit="route('users.edit', $user)" :password="route('users.password.edit', $user)" :delete="route('users.destroy', $user)" can-list="index-user"
                can-edit="edit-user" can-password="edit-user" can-delete="destroy-user"
                delete-confirm="Deseja excluir o usuário {{ $user->name }}?" />
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />


        <div class="detail-box">
            <div class="mb-1">
                <span class="title-detail-content">ID: </span>
                <span class="detail-content">{{ $user->id }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Usuário: </span>
                <span class="detail-content">{{ $user->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Nome: </span>
                <span class="detail-content">{{ $user->member?->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">E-mail: </span>
                <span class="detail-content">{{ $user->email }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Status: </span>
                <span class="detail-content">{{ $user->status->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Papel: </span>
                <span class="detail-content">{{ $user->getRoleNames()->implode(', ') ?: '-' }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Criado em:</span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Modificado em: </span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

    </div>
@endsection
