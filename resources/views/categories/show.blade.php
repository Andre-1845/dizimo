@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Categorias</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.admin') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('donations.index') }}" class="breadcrumb-link">Categorias</a>
                <span>/</span>
                <span>Visualizar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Detalhes da Categoria</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                <a href="{{ route('categories.index') }}" class="btn-primary align-icon-btn" title="Listar">
                    @include('components.icons.list')

                    <span class="hide-name-btn">Listar</span>
                </a>
                <!-- Fim - Botao LISTAR  -->

                <!-- Botao EDITAR (com icone)  -->
                <a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="btn-warning align-icon-btn"
                    title="Editar">
                    @include('components.icons.edit')

                    <span class="hide-name-btn">Editar</span>
                </a>
                <!-- Fim - Botao EDITAR -->


            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />


        <div class="detail-box">
            <div class="mb-1">
                <span class="title-detail-content">Categoria: </span>
                <span class="detail-content">{{ $category->name }}</span>
            </div>


            <div class="mb-1">
                <span class="title-detail-content">Tipo: </span>
                <span class="detail-content">{{ $category->type_label }}</span>
            </div>


            <div class="mb-1">
                <span class="title-detail-content">Criado em:</span>
                <span
                    class="detail-content">{{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Modificado em: </span>
                <span
                    class="detail-content">{{ \Carbon\Carbon::parse($category->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

    </div>
@endsection
