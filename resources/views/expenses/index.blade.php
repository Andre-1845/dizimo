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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                    </svg>


                    <span class="hide-name-btn">Painel</span>
                </a>
                <!-- Fim - Botao PAINEL  -->

                <!-- Botao NOVA DESPESA (com icone)  -->
                <div class="content-box-btn">
                    <a href="{{ route('expenses.create') }}" class="btn-success flex items-center space-x-1"
                        title="Cadastrar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>


                        <span>Nova Despesa</span>
                    </a>
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

    {{-- Botoes tabela --}}
    {{-- <td class="table-body table-actions align-icon-btn"> --}}
    {{-- VISUALIZAR --}}
    {{-- @can('show-expense')
                                    <a href="{{ route('expenses.show', ['expense' => $expense->id]) }} "
                                        class="btn-primary py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </a>
                                @endcan --}}
    {{-- EDITAR --}}
    {{-- @can('edit-expense')
                                    <a href="{{ route('expenses.edit', $expense) }}" class="btn-warning align-icon-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                @endcan --}}
    {{-- EXCLUIR --}}
    {{-- @can('destroy-expense')
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Excluir despesa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-danger py-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>

                                        </button>
                                    </form>
                                @endcan --}}

    {{-- </td> --}}
    {{-- FIM Botoes tabela --}}
