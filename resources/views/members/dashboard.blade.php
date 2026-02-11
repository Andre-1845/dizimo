@extends('layouts.admin')

@section('title', 'Meu Dízimo')

@section('content')

    <div class="content-header">
        {{-- Título centralizado acima --}}
        <div class="text-center mb-6">
            <h1 class="content-title">Minhas Colaborações</h1>
        </div>
        <x-smart-breadcrumb :items="[['label' => 'Minhas Colaborações']]" />
    </div>


    <div class="content-box-header">
        <h3 class="content-box-title">Listar colaborações</h3>

        <!-- Botoes (com icones)  -->
        <div class="content-box-btn">

            <!-- Botao PAINEL ANTIGO (com icone)  -->
            <div class="content-box-btn">
                <span class="btn-warning">
                    <a href="{{ route('dashboard.member') }}">
                        Visualizar dashboard antigo
                    </a>
                </span>
            </div>
            <!-- Fim - Botao PAINEL  -->

            <!-- Botao NOVA DOACAO (com icone)  -->
            @can('donations.create')
                <div class="content-box-btn">
                    <a href="{{ route('member.donations.create') }}" class="btn-success flex items-center space-x-1"
                        title="Cadastrar">
                        @include('components.icons.plus')

                        <span>Nova Colaboração</span>
                    </a>
                </div>
            @endcan
            <!--FIM  Botao NOVA DOACAO (com icone)  -->

        </div>
        <!-- Botoes (com icones)  -->
    </div>

    <x-alert />

    {{-- FILTRO --}}
    <form method="GET" class="flex gap-4 my-6">
        <select name="year" class="border rounded p-2">
            <option value="">Ano (todos)</option>
            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
            @endfor
        </select>

        <select name="month" class="border rounded p-2">
            <option value="">Mês (todos)</option>
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" @selected($month == $m)>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endfor
        </select>

        <button class="btn-primary">Filtrar</button>
    </form>

    {{-- RESUMO --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded shadow p-4">
            <p class="text-sm text-gray-500">Dízimo mensal previsto</p>
            <p class="text-xl font-bold text-blue-600">
                R$ {{ number_format($monthlyTithe ?? 0, 2, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded shadow p-4">
            <p class="text-sm text-gray-500">Total doado</p>
            <p class="text-xl font-bold text-green-600">
                R$ {{ number_format($totalDonated, 2, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded shadow p-4">
            <p class="text-sm text-gray-500">Situação</p>
            @if ($monthlyTithe && $totalDonated >= $monthlyTithe)
                <p class="text-green-600 font-semibold">Em dia</p>
            @else
                <p class="text-red-600 font-semibold">Pendente</p>
            @endif
        </div>

    </div>

    {{-- LISTAGEM --}}
    <div class="table-container">
        <div>{{ $user->member?->name }}</div>
        <table class="table">
            <thead>
                <tr class="table-row-header">
                    <th class="table-header">Data</th>
                    <th class="table-header">Categoria</th>
                    <th class="table-header">Cadastrado por</th>
                    <th class="table-header text-center">Valor</th>
                    <th class="table-header text-center">Comprovante</th>
                    <th class="table-header text-center">Confirmação</th>
                    <th class="table-header text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($donations as $donation)
                    <tr class="table-row-body">
                        <td class="table-body">
                            {{ $donation->donation_date->format('d/m/Y') }}
                        </td>
                        <td class="table-body">
                            {{ $donation->category->name }}
                        </td>
                        <td class="table-body">
                            {{ $donation->user->name }}
                        </td>
                        <td class="table-body text-right text-green-600 font-semibold">
                            R$ {{ money($donation->amount) }}
                        </td>

                        {{-- Link do Recibo --}}
                        <td class="table-body text-center">
                            @if ($donation->receipt_path)
                                <div class="flex justify-center items-center">
                                    <a href="{{ asset('storage/' . $donation->receipt_path) }}" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        @include('components.icons.doc_view')
                                    </a>
                                </div>
                            @else
                                —
                            @endif
                        </td>
                        {{-- FIM Link do Recibo --}}

                        <td class="table-body text-center">
                            <div class="flex flex-col items-center gap-1">
                                @if ($donation->is_confirmed)
                                    <span class="text-green-600 font-semibold">
                                        Confirmada
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $donation->confirmed_at->format('d/m/Y H:i') }}
                                    </span>
                                @else
                                    <span class="text-yellow-600">
                                        Aguardando validação
                                    </span>
                                @endif
                            </div>
                        </td>
                        <x-table-actions-icons :show="route('member.donations.show', $donation)" :edit="!$donation->is_confirmed ? route('member.donations.edit', $donation) : null" :delete="route('member.donations.destroy', $donation)"
                            can-show="donations.view" can-edit="donations.edit" can-delete="member.donations.delete"
                            confirm="Deseja excluir esta colaboração?" />
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="py-4 text-center text-gray-500">
                            Nenhuma colaboração encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $donations->links() }}
        </div>
    </div>

    {{-- EDITAR DÍZIMO --}}
    <div class="bg-white rounded shadow p-4 mb-6">
        <h2 class="font-semibold mb-3">Meu dízimo mensal previsto</h2>

        <form method="POST" action="{{ route('dashboard.member.update-tithe') }}" class="flex gap-4 items-end">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">Valor (R$)</label>
                <input type="number" step="0.01" name="monthly_tithe" value="{{ old('monthly_tithe', $monthlyTithe) }}"
                    class="border rounded p-2 w-40">
            </div>

            <button class="btn-primary">
                Atualizar
            </button>
        </form>
    </div>


@endsection
