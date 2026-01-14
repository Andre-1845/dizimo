@extends('layouts.admin')

@section('title', 'Nova Despesa')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Despesas</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('expenses.index') }}" class="breadcrumb-link">Despesas</a>
                <span>/</span>
                <span>Cadastrar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Nova Despesa</h3>
            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                @can('index-expense')
                    <a href="{{ route('expenses.index') }}" class="btn-primary align-icon-btn" title="Listar">
                        @include('components.icons.list')
                        <span class="hide-name-btn">Listar</span>
                    </a>
                @endcan
                <!-- Fim - Botao LISTAR  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        @can('create-expense')
            <form method="POST" enctype="multipart/form-data" action="{{ route('expenses.store') }}"
                class="bg-white rounded-xl shadow p-6 space-y-4">

                @csrf

                {{-- Categoria --}}
                <div>
                    <label class="form-label">Categoria</label>
                    <select name="category_id" class="form-input">
                        <option value="">Selecione</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Forma de pagamento --}}
                <div>
                    <label class="form-label">Forma de Pagamento</label>
                    <select name="payment_method_id" class="form-input">
                        <option value="">Selecione</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->id }}" @selected(old('payment_method_id') == $method->id)>
                                {{ $method->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('payment_method_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Data --}}
                <div>
                    <label class="form-label">Data</label>
                    <input type="date" name="expense_date" class="form-input"
                        value="{{ old('expense_date', now()->toDateString()) }}">
                    @error('expense_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Valor --}}
                <div>
                    <label class="form-label">Valor</label>
                    <input type="number" step="0.01" name="amount" class="form-input" value="{{ old('amount') }}">
                    @error('amount')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descrição --}}
                <div>
                    <label class="form-label">Descrição</label>
                    <input type="text" name="description" class="form-input" value="{{ old('description') }}">
                </div>

                {{-- Observações --}}
                <div>
                    <label class="form-label">Observações</label>
                    <textarea name="notes" class="form-input">{{ old('notes') }}</textarea>
                </div>

                {{-- Comprovante --}}
                <div>
                    <label class="form-label">Comprovante</label>
                    <input type="file" name="receipt" accept=".pdf,.jpg,.jpeg,.png"
                        class="block w-full text-sm text-gray-600
                      file:mr-4 file:py-2 file:px-4
                      file:rounded file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">Tamanho máximo: 2MB</p>
                    @error('receipt')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botão --}}
                <div class="btn-md-div">
                    <button class="btn-success-md">
                        @include('components.icons.save')
                        Salvar Despesa
                    </button>
                </div>
            </form>
        @endcan

    </div> <!-- FIM Content-Box  -->
@endsection
