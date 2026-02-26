@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->
    <div class="w-full">
        <div class="content-wrapper-full">
            <div class="content-header">
                <h2 class="content-title">Perfil</h2>
                <x-smart-breadcrumb :items="[['label' => $user->name, 'url' => route('profile.show', $user)], ['label' => 'Perfil']]" />
                </nav>
            </div>
        </div>

        <!-- Titulo e trilha de navegacao -->


        <x-alert />


        <div class="content-box"> <!-- Content-Box  -->
            <div class="content-box-header">
                <h3 class="content-box-title">Perfil</h3>

                <!-- Botoes (com icones)  -->
                <x-action-buttons :edit="route('profile.edit', $user)" :password="route('profile.password.edit', $user)" can-edit="profile.edit"
                    can-password="profile.password" />
                <!-- Botoes (com icones)  -->

            </div>

            {{-- Listar registro --}}
            <div class="detail-box">
                <div class="mb-1">
                    <span class="hidden">{{ $user->id }}</span>
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
                    <span class="title-detail-content">Telefone: </span>
                    <span
                        class="detail-content">{{ $user->member && $user->member->phone ? format_phone($user->member->phone) : '-' }}</span>
                </div>
                <div class="mb-1">
                    <span class="title-detail-content">Igreja: </span>
                    <span class="detail-content">{{ $user->member->church->name }}</span>
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
                    <span
                        class="detail-content">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}</span>
                </div>
                <div class="mb-1">
                    <span class="title-detail-content">Modificado em: </span>
                    <span
                        class="detail-content">{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
