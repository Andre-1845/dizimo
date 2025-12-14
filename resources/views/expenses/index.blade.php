@extends('layouts.admin')

@section('title', 'Despesas')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Despesas</h1>

        <a href="{{ route('expenses.create') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Nova Despesa
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b text-left">
                    <th>Categoria</th>
                    <th>Forma</th>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($expenses as $expense)
                    <tr class="border-b last:border-0">
                        <td class="py-2">{{ $expense->category->name ?? '—' }}</td>
                        <td class="py-2">{{ $expense->paymentMethod->name ?? '—' }}</td>
                        <td class="py-2">{{ $expense->expense_date->format('d/m/Y') }}</td>
                        <td class="py-2">{{ $expense->description ?? '—' }}</td>
                        <td class="py-2 text-right text-red-600 font-semibold">
                            R$ {{ number_format($expense->amount, 2, ',', '.') }}
                        </td>
                        <td class="py-2 text-right space-x-2">
                            <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-600 hover:underline">
                                Editar
                            </a>

                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline"
                                onsubmit="return confirm('Excluir despesa?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    Excluir
                                </button>
                            </form>
                        </td>
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
s
