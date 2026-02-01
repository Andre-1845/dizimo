@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Despesas</h2>
            <x-smart-breadcrumb :items="[['label' => 'Despesas', 'url' => route('expenses.index')], ['label' => 'Detalhes']]" />
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
            <span class="inline-flex items-center gap-2">
                @if ($expense->is_confirmed)
                    <span class="text-green-600 font-semibold">Aprovada</span>
                    <span class="text-sm text-gray-600">
                        ({{ $expense->approved_at->format('d/m/Y H:i') }}
                        – {{ $expense->approver->name }})
                    </span>
                @else
                    <span class="text-orange-500 font-semibold">
                        Aguardando confirmação
                    </span>
                @endif
            </span>
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
                <span class="title-detail-content">Comprovante (doc): </span>
                <span class="detail-content">
                    @if ($expense->receipt_path)
                        <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank"
                            class="text-blue-600 font-bold hover:underline">
                            @include('components.icons.doc_view')
                        </a>
                    @else
                        —
                    @endif
                </span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Criado em:</span>
                <span
                    class="detail-content">{{ \Carbon\Carbon::parse($expense->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Modificado em: </span>
                <span
                    class="detail-content">{{ \Carbon\Carbon::parse($expense->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>
    </div> <!-- FIM Content-Box  -->
@endsection
