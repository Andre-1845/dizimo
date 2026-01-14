@extends('layouts.admin')

@section('title', 'Despesas')

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Despesas</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>Despesas</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar Despesas</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao PAINEL (com icone)  -->
                <a href="{{ route('dashboard.index') }}" class="btn-primary align-icon-btn" title="Painel">
                    @include('components.icons.painel_icon')
                    <span class="hide-name-btn">Painel</span>
                </a>
                <!-- Fim - Botao PAINEL  -->

                <!-- Botao NOVA DESPESA (com icone)  -->
                <div class="content-box-btn">
                    @can('create-expense')
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
                            <td class="table-body text-right">
                                R$ {{ number_format($expense->amount, 2, ',', '.') }}
                            </td>
                            {{-- Link do Recibo --}}
                            <td class="table-body">
                                @if ($expense->receipt_path)
                                    <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>

                                    </a>
                                @else
                                    —
                                @endif
                            </td> {{-- FIM Link do Recibo --}}
                            <x-table-actions-icons :show="route('expenses.show', $expense)" :edit="route('expenses.edit', $expense)" :delete="route('expenses.destroy', $expense)"
                                can-show="show-expense" can-edit="edit-expense" can-delete="destroy-expense"
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
