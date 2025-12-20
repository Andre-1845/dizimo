@extends('layouts.admin')

@section('title', 'Doações')

@section('content')

    <div class="content-wrapper">
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                    </svg>


                    <span class="hide-name-btn">Painel</span>
                </a>
                <!-- Fim - Botao PAINEL  -->

                <!-- Botao NOVA DOACAO (com icone)  -->
                <div class="content-box-btn">
                    <a href="{{ route('donations.create') }}" class="btn-success flex items-center space-x-1"
                        title="Cadastrar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        <span>Nova Doacao</span>
                    </a>
                </div>
                <!--FIM  Botao NOVA DOACAO (com icone)  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

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
                            <td class="table-body">{{ $donation->member->name ?? '—' }}</td>
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
