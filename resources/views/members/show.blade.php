@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Membros</h2>
            <x-smart-breadcrumb :items="[['label' => 'Membros', 'url' => route('members.index')], ['label' => 'Detalhes']]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Detalhes</h3>

            <!-- Botoes (com icones)  -->
            <x-action-buttons :list="Gate::allows('viewAny', \App\Models\Member::class) ? route('members.index') : null" :edit="Gate::allows('update', $member) ? route('members.edit', $member) : null" :delete="Gate::allows('delete', $member) ? route('members.destroy', $member) : null"
                delete-confirm="Deseja excluir o membro {{ $member->name }} ?" />
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />


        <div class="detail-box">
            <div class="mb-1">
                <span class="title-detail-content">ID: </span>
                <span class="detail-content">{{ $member->id }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Nome: </span>
                <span class="detail-content">{{ $member?->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Usuário: </span>
                <span class="detail-content">{{ $member->user->name ?? '-' }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">E-mail: </span>
                <span class="detail-content">{{ $member->user->email ?? '—' }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Telefone: </span>
                <span class="detail-content">{{ $member->phone_formatted ?? '—' }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Status: </span>
                <span class="detail-content {{ $member->active ? 'text-green-600' : 'text-red-600' }}">
                    {{ $member->active ? 'Ativo' : 'Inativo' }}<span>
            </div>

            <div class="mb-1">
                <span class="title-detail-content">Criado em:</span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($member->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Modificado em: </span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($member->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

    </div>
@endsection
