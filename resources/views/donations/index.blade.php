@extends('layouts.admin')

@section('title', 'Doações')

@section('content')

    <div class="content-wrapper-full">
        <div class="content-header">
            <h2 class="content-title">Receitas e Doações</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>Receitas</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar Receitas</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao PAINEL (com icone)  -->
                <a href="{{ route('dashboard.index') }}" class="btn-primary align-icon-btn" title="Painel">
                    @include('components.icons.painel_icon')
                    <span class="hide-name-btn">Painel</span>
                </a>
                <!-- Fim - Botao PAINEL  -->

                <!-- Botao NOVA DOACAO (com icone)  -->
                <div class="content-box-btn">
                    <a href="{{ route('donations.create') }}" class="btn-success flex items-center space-x-1"
                        title="Cadastrar">
                        @include('components.icons.plus')

                        <span>Nova Doacao</span>
                    </a>
                </div>
                <!--FIM  Botao NOVA DOACAO (com icone)  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />


        <x-filters.generic :filters="$filters" :route="route('donations.index')" />




        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header">Membro</th>
                        <th class="table-header">Categoria</th>
                        <th class="table-header table-cell-lg-hidden">Forma</th>
                        <th class="table-header">Data</th>
                        <th class="table-header table-cell-lg-hidden">Cadastrado por</th>
                        <th class="table-header center">Valor</th>
                        <th class="table-header center">Doc</th>
                        <th class="table-header center">Ações</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($donations as $donation)
                        <tr class="table-row-body">
                            <td class="table-body">{{ $donation->display_donor ?? '—' }}</td>
                            <td class="table-body">{{ $donation->category->name ?? '—' }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $donation->paymentMethod->name ?? '—' }}</td>
                            <td class="table-body">
                                {{ \Carbon\Carbon::parse($donation->donation_date)->format('d/m/Y') }}
                            </td>
                            <td class="table-body table-cell-lg-hidden">{{ $donation->user->name ?? '—' }}
                            </td>
                            </td>
                            <td class="table-body text-right text-green-600 font-semibold">
                                R$ {{ number_format($donation->amount, 2, ',', '.') }}
                            </td>
                            {{-- Link do Recibo --}}
                            <td class="table-body">
                                @if ($donation->receipt_path)
                                    <a href="{{ asset('storage/' . $donation->receipt_path) }}" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        @include('components.icons.doc_view')
                                    </a>
                                @else
                                    —
                                @endif
                            </td> {{-- FIM Link do Recibo --}}

                            <x-table-actions-icons :show="route('donations.show', $donation)" :edit="route('donations.edit', $donation)" :delete="route('donations.destroy', $donation)"
                                confirm="Deseja excluir esta receita/doação?" />
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-600">
                                Nenhuma doação registrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $donations->links() }}
            </div>
        </div>

    @endsection
