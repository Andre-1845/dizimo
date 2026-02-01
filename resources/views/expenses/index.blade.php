@extends('layouts.admin')

@section('title', 'Despesas')

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Despesas</h2>
            <x-smart-breadcrumb :items="[['label' => 'Despesas']]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar Despesas</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao PAINEL (com icone)  -->
                <a href="{{ route('dashboard.admin') }}" class="btn-primary align-icon-btn" title="Painel">
                    @include('components.icons.painel_icon')
                    <span class="hide-name-btn">Painel</span>
                </a>
                <!-- Fim - Botao PAINEL  -->

                <!-- Botao NOVA DESPESA (com icone)  -->
                <div class="content-box-btn">
                    @can('expenses.create')
                        <a href="{{ route('expenses.create') }}" class="btn-success flex items-center space-x-1"
                            title="Cadastrar">
                            @include('components.icons.plus')
                            <span>Nova Despesa</span>
                        </a>
                    @endcan
                </div>
                <!--FIM  Botao NOVA DESPESA (com icone)  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />


        <x-filters.generic :filters="$filters" :route="route('expenses.index')" />


        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header">Categoria</th>
                        <th class="table-header">Forma</th>
                        <th class="table-header center">Data</th>
                        <th class="table-header">Descrição</th>
                        <th class="table-header table-cell-lg-hidden">Cadastrado por</th>
                        <th class="table-header table-cell-lg-hidden">Editado em</th>
                        <th class="table-header center">Valor</th>
                        <th class="table-header center">Doc</th>
                        <th class="table-header center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expenses as $expense)
                        <tr class="table-row-body">
                            <td class="table-body">{{ $expense->category->name ?? '—' }}</td>
                            <td class="table-body">{{ $expense->paymentMethod->name ?? '—' }}</td>
                            <td class="table-body">{{ $expense->expense_date->format('d/m/Y') }}</td>
                            <td class="table-body">{{ $expense->description ?? '—' }}</td>
                            <td class="table-body">{{ $expense->user->name ?? '—' }}</td>
                            <td class="table-body">{{ $expense->updated_at->format('d/m/Y') }}</td>
                            <td @class([
                                'table-body text-right font-semibold',
                                'text-green-600' => $expense->is_confirmed,
                                'text-orange-500' => !$expense->is_confirmed,
                            ])
                                title="{{ $expense->is_confirmed ? 'Despesa aprovada' : 'Aguardando validação' }}">
                                R$ {{ money($expense->amount) }}
                            </td>
                            {{-- Link do Recibo --}}
                            <td class="table-body">
                                @if ($expense->receipt_path)
                                    <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        @include('components.icons.doc_view')

                                    </a>
                                @else
                                    —
                                @endif
                            </td> {{-- FIM Link do Recibo --}}
                            <x-table-actions-icons :show="route('expenses.show', $expense)" :edit="route('expenses.edit', $expense)" :delete="route('expenses.destroy', $expense)"
                                can-show="expenses.view" can-edit="expenses.edit" can-delete="expenses.delete"
                                confirm="Deseja excluir esta despesa?" />

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">
                                Nenhuma despesa registrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $expenses->links() }}
            </div>
        </div>

    @endsection
