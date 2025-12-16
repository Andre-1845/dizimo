@extends('layouts.admin')

@section('title', 'Meu Painel')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Transparência Financeira</h1>

    <form method="GET" class="flex flex-wrap gap-2 mb-6">
        <select name="month" class="border rounded p-2">
            <option value="">Todos os meses</option>
            @foreach (range(1, 12) as $m)
                <option value="{{ $m }}" @selected($m == $month)>
                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                </option>
            @endforeach
        </select>

        <select name="year" class="border rounded p-2">
            @foreach (range(now()->year - 3, now()->year) as $y)
                <option value="{{ $y }}" @selected($y == $year)>
                    {{ $y }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Filtrar
        </button>
    </form>


    {{-- CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Doações</p>
            <p class="text-2xl font-bold text-green-600">
                R$ {{ number_format($totalDonations, 2, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Despesas do mês</p>
            <p class="text-2xl font-bold text-red-600">
                R$ {{ number_format($totalExpenses, 2, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Saldo do mês</p>
            <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                R$ {{ number_format($balance, 2, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- DESPESAS POR CATEGORIA --}}
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Despesas por Categoria</h2>

        <ul class="space-y-2">
            @foreach ($expensesByCategory as $item)
                <li class="flex justify-between border-b pb-1">
                    <span>{{ $item->name }}</span>
                    <span class="font-semibold text-red-600">
                        R$ {{ number_format($item->total, 2, ',', '.') }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- MINHAS DOAÇÕES --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Minhas Doações</h2>

        @if ($myDonations->isEmpty())
            <p class="text-gray-500">Você ainda não registrou doações.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left">
                        <th>Data</th>
                        <th class="text-right">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myDonations as $donation)
                        <tr class="border-b">
                            <td class="py-2">
                                {{ $donation->donation_date->format('d/m/Y') }}
                            </td>
                            <td class="py-2 text-right text-green-600 font-semibold">
                                R$ {{ number_format($donation->amount, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $myDonations->links() }}
            </div>
        @endif
    </div>
    {{ $myDonations->appends(request()->query())->links() }}

@endsection
