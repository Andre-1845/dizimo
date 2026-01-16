@extends('layouts.admin')

@section('title', 'Editar Despesa')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Despesas</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.admin') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('expenses.index') }}" class="breadcrumb-link">Despesas</a>
                <span>/</span>
                <span>Editar Despesa</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Editar Despesa</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                @can('expenses.view')
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

        @can('expenses.edit')
            <form method="POST" action="{{ route('expenses.update', $expense) }}"
                class="bg-white rounded-xl shadow p-6 space-y-4">

                @csrf
                @method('PUT')

                <div>
                    <label class="form-label">Categoria</label>
                    <select name="category_id" class="form-input">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($expense->category_id == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                        @error('category_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </select>
                </div>

                <div>
                    <label class="form-label">Forma de Pagamento</label>
                    <select name="payment_method_id" class="form-input">
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->id }}" @selected($expense->payment_method_id == $method->id)>
                                {{ $method->name }}
                            </option>
                        @endforeach
                        @error('payment_method_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </select>
                </div>

                <div>
                    <label class="form-label">Data</label>
                    <input type="date" name="expense_date" value="{{ $expense->expense_date->format('Y-m-d') }}"
                        class="form-input">
                    @error('expense_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Valor</label>
                    <input type="number" step="0.01" name="amount" value="{{ $expense->amount }}" class="form-input">
                    @error('amount')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Descrição</label>
                    <input type="text" name="description" value="{{ $expense->description }}" class="form-input">
                </div>

                <div>
                    <label class="form-label">Observações</label>
                    <textarea name="notes" class="form-input">{{ $expense->notes }}</textarea>
                </div>
                <div>
                    <label class="form-label">Comprovante</label>
                    <input type="file" name="receipt" value={{ $expense->receipt }} accept=".pdf,.jpg,.jpeg,.png"
                        class="block w-full text-sm text-gray-600
                      file:mr-4 file:py-2 file:px-4
                      file:rounded file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">
                        Tamanho máximo: 2MB
                    </p>
                    @error('receipt')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="btn-md-div gap-2">
                    <button type="submit" class="btn-success-md">
                        @include('components.icons.save')
                        Atualizar
                    </button>

                    <a href="{{ route('expenses.index') }}" class="btn-danger-md">
                        Cancelar
                    </a>
                </div>

            </form>
        @endcan
    </div> {{-- FIM Content Box --}}
@endsection
