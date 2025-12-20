@extends('layouts.admin')

@section('title', 'Editar Membro')

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Membros</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>Membros</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar Membros</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                <a href="{{ route('members.index') }}" class="btn-primary align-icon-btn" title="Listar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>

                    <span class="hide-name-btn">Listar</span>
                </a>
                <!-- Fim - Botao LISTAR  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>


        <x-alert />


        <form action="{{ route('members.update', $member) }}" method="POST" class="content-box space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label">Nome </label>
                <input type="text" name="name" class="form-input" value="{{ $member->name }}"required>
            </div>

            <div>
                <label class="form-label">Usuário </label>
                <input type="text" name="user_name" class="form-input" value="{{ $member->user?->name }}" readonly>
            </div>

            <div>
                <label class="form-label">Telefone</label>
                <input type="text" name="phone" class="form-input" value="{{ $member->phone }}">
            </div>

            <div>
                <label class="form-label">Dízimo (R$)</label>
                <input class="form-input" type="number" step="0.01" name="monthly_tithe"
                    value="{{ old('monthly_tithe', $member->monthly_tithe) }}">
            </div>

            <div>
                <label>
                    <input type="checkbox" name="active" {{ $member->active ? 'checked' : '' }}>
                    Ativo
                </label>
            </div>

            <div class="btn-md-div">
                <button class="btn-success-md">
                    @include('components.icons.save')
                    Salvar
                </button>
            </div>
        </form>
    </div>
@endsection
