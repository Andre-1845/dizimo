@extends('layouts.admin')

@section('title', 'Editar Despesa')

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
                <a href="{{ route('expenses.index') }}" class="btn-primary align-icon-btn" title="Listar">
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
                </select>
            </div>

            <div>
                <label class="form-label">Descrição</label>
                <input type="text" name="description" value="{{ $expense->description }}" class="form-input">
            </div>

            <div>
                <label class="form-label">Forma de Pagamento</label>
                <select name="payment_method_id" class="form-input">
                    @foreach ($paymentMethods as $method)
                        <option value="{{ $method->id }}" @selected($expense->payment_method_id == $method->id)>
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">Data</label>
                <input type="date" name="expense_date" value="{{ $expense->expense_date->format('Y-m-d') }}"
                    class="form-input">
            </div>

            <div>
                <label class="form-label">Valor</label>
                <input type="number" step="0.01" name="amount" value="{{ $expense->amount }}" class="form-input">
            </div>

            <div>
                <label class="form-label">Observações</label>
                <textarea name="notes" class="form-input">{{ $expense->notes }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn-primary-md">
                    Atualizar
                </button>

                <a href="{{ route('expenses.index') }}" class="btn-danger-md">
                    Cancelar
                </a>
            </div>

        </form>
    </div> {{-- FIM Content Box --}}
@endsection
