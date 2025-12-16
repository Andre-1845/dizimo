@extends('layouts.admin')

@section('title', 'Meu Dízimo')

@section('content')

    <x-alert />

    <div class="content-header">
        <h1 class="text-2xl font-bold mb-6">Minhas Doações</h1>

        <a href="{{ route('member.create_donation') }}" class="btn-primary">
            Nova Doação
        </a>
    </div>


    {{-- FILTRO --}}
    <form method="GET" class="flex gap-4 mb-6">
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
        <div>{{ $user->name }}</div>
        <table class="table">
            <thead>
                <tr class="table-row-header">
                    <th class="table-header">Data</th>
                    <th class="table-header">Categoria</th>
                    <th class="table-header">Cadastrado por</th>
                    <th class="table-header">Valor</th>
                    <th class="table-header center">Comprovante</th>
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
                            R$ {{ number_format($donation->amount, 2, ',', '.') }}
                        </td>
                        {{-- Link do Recibo --}}
                        <td class="table-body table-actions">
                            @if ($donation->receipt_path)
                                <a href="{{ asset('storage/' . $donation->receipt_path) }}" target="_blank"
                                    class="text-blue-600 hover:underline">
                                    Ver
                                </a>
                            @else
                                —
                            @endif
                        </td> {{-- FIM Link do Recibo --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="py-4 text-center text-gray-500">
                            Nenhuma doação encontrada.
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

        <form method="POST" action="{{ route('members.update_tithe') }}" class="flex gap-4 items-end">
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
