@extends('layouts.admin')

@section('title', 'Nova Categoria')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Categorias</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.admin') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('categories.index') }}" class="breadcrumb-link">Categorias</a>
                <span>/</span>
                <span>Editar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Editar Categoria</h3>
            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                @can('index-category')
                    <a href="{{ route('categories.index') }}" class="btn-primary align-icon-btn" title="Listar">
                        @include('components.icons.list')

                        <span class="hide-name-btn">Listar</span>
                    </a>
                @endcan
                <!-- Fim - Botao LISTAR  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        <form method="POST" action="{{ route('categories.update', $category) }}"
            class="bg-white rounded-xl shadow p-6 space-y-4">

            @csrf
            @method('PUT')

            <div>
                <label class="form-label">Categoria</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $category->name) }}">
            </div>
            @error('category.name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror



            @php
                $types = [
                    'income' => 'Receita',
                    'expense' => 'Despesa',
                ];
            @endphp

            <select name="type" class="form-input">
                <option value="">Selecione</option>
                @foreach ($types as $value => $label)
                    <option value="{{ $value }}" @selected(old('type', $category->type) === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('category.type')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror


            <div class="btn-md-div">
                <button class="btn-success-md">
                    @include('components.icons.save')
                    Salvar
                </button>
            </div>

        </form>

    @endsection
