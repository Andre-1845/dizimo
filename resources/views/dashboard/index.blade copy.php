@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

{{-- CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    {{-- Doações --}}
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Doações (mês)</p>
        <p class="text-2xl font-bold text-green-600">
            R$ {{ number_format($totalDonationsMonth, 2, ',', '.') }}
        </p>
    </div>

    {{-- Despesas --}}
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Despesas (mês)</p>
        <p class="text-2xl font-bold text-red-600">
            R$ {{ number_format($totalExpensesMonth, 2, ',', '.') }}
        </p>
    </div>

    {{-- Saldo --}}
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Saldo do mês</p>
        <p class="text-2xl font-bold {{ $balanceMonth >= 0 ? 'text-blue-600' : 'text-red-600' }}">
            R$ {{ number_format($balanceMonth, 2, ',', '.') }}
        </p>
    </div>

    {{-- Membros --}}
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Membros</p>
        <p class="text-2xl font-bold text-gray-800">
            {{ $membersCount }}
        </p>
    </div>

</div>

{{-- LISTAS --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Últimas Doações --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Últimas Doações</h2>

        @if ($lastDonations->isEmpty())
        <p class="text-gray-500">Nenhuma doação registrada.</p>
        @else
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="pb-2">Membro</th>
                    <th class="pb-2">Data</th>
                    <th class="pb-2 text-right">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lastDonations as $donation)
                <tr class="border-b last:border-0">
                    <td class="py-2">
                        {{ $donation->member->name ?? '—' }}
                    </td>
                    <td class="py-2">
                        {{ \Carbon\Carbon::parse($donation->donation_date)->format('d/m/Y') }}
                    </td>
                    <td class="py-2 text-right text-green-600 font-semibold">
                        R$ {{ number_format($donation->amount, 2, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Últimas Despesas --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Últimas Despesas</h2>

        @if ($lastExpenses->isEmpty())
        <p class="text-gray-500">Nenhuma despesa registrada.</p>
        @else
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="pb-2">Categoria</th>
                    <th class="pb-2">Data</th>
                    <th class="pb-2 text-right">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lastExpenses as $expense)
                <tr class="border-b last:border-0">
                    <td class="py-2">
                        {{ $expense->category->name ?? '—' }}
                    </td>
                    <td class="py-2">
                        {{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}
                    </td>
                    <td class="py-2 text-right text-red-600 font-semibold">
                        R$ {{ number_format($expense->amount, 2, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>

@endsection