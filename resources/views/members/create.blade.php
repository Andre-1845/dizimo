@extends('layouts.admin')

@section('title', 'Novo Membro')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Doações</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.member') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('members.index') }}" class="breadcrumb-link">Membros</a>
                <span>/</span>
                <span>Cadastrar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h2 class="content-title">Novo Membro</h2>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                <a href="{{ route('dashboard.member') }}" class="btn-primary align-icon-btn" title="Listar">
                    @include('components.icons.list')

                    <span class="hide-name-btn">Listar</span>
                </a>
                <!-- Fim - Botao LISTAR  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        <form action="{{ route('members.store') }}" method="POST" class="content-box space-y-4">
            @csrf

            <div>
                <label class="form-label">Nome </label>
                <input type="text" name="name" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Telefone</label>
                <input type="text" name="phone" class="form-input">
            </div>

            <div>
                <label class="form-label">Dízimo (R$)</label>
                <input class="form-input" type="number" step="0.01" name="monthly_tithe">
            </div>

            <div>
                <label>
                    <input type="checkbox" name="active" value="1" checked>
                    Ativo
                </label>
            </div>

            <div class="btn-md-div">
                <button class="btn-success-md ">
                    @include('components.icons.save')
                    Salvar
                </button>
            </div>
        </form>
    </div>
@endsection
