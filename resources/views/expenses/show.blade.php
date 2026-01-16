@extends('layouts.admin')

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
                <span>Visualizar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Detalhes de Despesa</h3>

            <!-- Botoes (com icones)  -->

            <div class="content-box-btn">
                <x-action-buttons :list="route('expenses.index')" :edit="route('expenses.edit', $expense)" :delete="route('expenses.destroy', $expense)" can-list="expenses.view"
                    can-edit="expenses.edit" can-delete="expenses.delete"
                    delete-confirm="Tem certeza que deseja excluir esta despesa?" />
            </div>
            <!-- Botoes (com icones)  -->
        </div>


        <x-alert />


        <div class="detail-box">
            <div class="mb-1">
                <span class="title-detail-content">ID: </span>
                <span class="detail-content">{{ $expense->id }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Descrição: </span>
                <span class="detail-content">{{ $expense->description }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Categoria: </span>
                <span class="detail-content">{{ $expense->category?->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Valor: </span>
                <span class="detail-content">{{ $expense->amount }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Lançado por: </span>
                <span class="detail-content">{{ $expense->user->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Data da despesa: </span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Notas: </span>
                <span class="detail-content">{{ $expense->notes }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Criado em:</span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($expense->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Modificado em: </span>
                <span
                    class="detail-content">{{ \Carbon\Carbon::parse($expense->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>
    </div> <!-- FIM Content-Box  -->
@endsection
