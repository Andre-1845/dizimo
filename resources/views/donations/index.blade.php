@extends('layouts.admin')

@section('title', 'Doações')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Doações</h1>

        <a href="{{ route('donations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nova Doação
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b text-left">
                    <th class="pb-2">Membro</th>
                    <th class="pb-2">Categoria</th>
                    <th class="pb-2">Forma</th>
                    <th class="pb-2">Data</th>
                    <th class="pb-2 text-right">Valor</th>
                    <th class="pb-2 text-right">Ações</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($donations as $donation)
                    <tr class="border-b last:border-0">
                        <td class="py-2">{{ $donation->member->name ?? '—' }}</td>
                        <td class="py-2">{{ $donation->category->name ?? '—' }}</td>
                        <td class="py-2">{{ $donation->paymentMethod->name ?? '—' }}</td>
                        <td class="py-2">
                            {{ \Carbon\Carbon::parse($donation->donation_date)->format('d/m/Y') }}
                        </td>
                        <td class="py-2 text-right text-green-600 font-semibold">
                            R$ {{ number_format($donation->amount, 2, ',', '.') }}
                        </td>
                        <td class="py-2 text-right space-x-2">
                            <a href="{{ route('donations.edit', $donation) }}" class="btn-warning">
                                Editar
                            </a>

                            <form action="{{ route('donations.destroy', $donation) }}" method="POST" class="inline"
                                onsubmit="return confirm('Deseja excluir esta doação?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-danger">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">
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
