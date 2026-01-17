@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Usuários</h2>
            <x-smart-breadcrumb :items="[
                ['label' => 'Usuários', 'url' => route('users.index')],
                ['label' => $user->name, 'url' => route('users.show', $user)],
                ['label' => 'Visualizar'],
            ]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Detalhes</h3>

            <!-- Botoes (com icones)  -->
            <x-action-buttons :list="Gate::allows('viewAny', \App\Models\User::class) ? route('users.index') : null" :edit="Gate::allows('update', $user) ? route('users.edit', $user) : null" :password="Gate::allows('editPassword', $user) ? route('users.password.edit', $user) : null" :delete="Gate::allows('delete', $user) ? route('users.destroy', $user) : null"
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
