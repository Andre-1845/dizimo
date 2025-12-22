@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Papéis</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('roles.index') }}" class="breadcrumb-link">Papeis</a>
                <span>/</span>
                <span>Visualizar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Visualizar</h3>

            <!-- Botoes (com icones)  -->
            <x-action-buttons :list="route('roles.index')" :edit="route('roles.edit', $role)" :delete="route('roles.destroy', $role)" can-list="index-role"
                can-edit="edit-role" can-delete="destroy-role"
                delete-confirm="Deseja excluir o papel {{ $role->name }}?" />
            <!-- Botoes (com icones)  -->

        </div>

        <x-alert />

        <div class="detail-box">
            <div class="mb-2">
                <span class="title-detail-content">ID: </span>
                <span class="detail-content">{{ $role->id }}</span>
            </div>

            <div class="mb-2">
                <span class="title-detail-content">Nome: </span>
                <span class="detail-content">{{ $role?->name }}</span>
            </div>

            <div class="mb-2">
                <span class="title-detail-content">Criado em:</span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y') }}</span>
            </div>
            <div class="mb-2">
                <span class="title-detail-content">Modificado em: </span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($role->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>

            <!-- Botao PERMISSOES (com icone)  -->
            <div class="content-box-btn">
                <a href="{{ route('role-permissions.index', ['role' => $role->id]) }}"
                    class="btn-primary flex items-center space-x-1">
                    @include('components.icons.permissions')
                    <span>Permissões</span>
                </a>
            </div>
            <!--FIM  Botao PERMISSOES (com icone)  -->
        </div>

    </div>
@endsection
