@extends('layouts.admin')

@section('title', 'Nova Categoria')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Categorias</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('categories.index') }}" class="breadcrumb-link">Categorias</a>
                <span>/</span>
                <span>Cadastrar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Nova Categoria</h3>
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

        <form method="POST" action="{{ route('categories.store') }}" class="bg-white rounded-xl shadow p-6 space-y-4">

            @csrf
            @method('POST')

            {{-- <div>
                <label class="form-label">Categoria</label>
                <select name="name" class="form-input">
                    <option value="">Selecione</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div> --}}

            {{-- <div>
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-input">
                    <option value="">Selecione</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div> --}}

            {{-- <div>
                <label class="form-label">Forma de Pagamento</label>
                <select name="payment_method_id" class="form-input">
                    <option value="">Selecione</option>
                    @foreach ($paymentMethods as $method)
                        <option value="{{ $method->id }}">
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('payment_method_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror --}}

            <div>
                <label class="form-label">Categoria</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}">
            </div>



            @php
                $types = [
                    'income' => 'Receita',
                    'expense' => 'Despesa',
                ];
            @endphp

            <select name="type" class="form-input">
                <option value="">Selecione</option>
                @foreach ($types as $value => $label)
                    <option value="{{ $value }}" @selected(old('type') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>


            <div class="btn-md-div">
                <button class="btn-success-md">
                    @include('components.icons.save')
                    Salvar
                </button>
            </div>

        </form>

    @endsection
