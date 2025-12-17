@extends('layouts.admin')

@section('title', 'Doações')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Doações</h1>

        <a href="{{ route('donations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nova Doação
        </a>
    </div>

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
                        <td class="table-body table-cell-lg-hidden">{{ $donation->user->name ?? '—' }}</td>
                        </td>
                        <td class="table-body text-right text-green-600 font-semibold">
                            R$ {{ number_format($donation->amount, 2, ',', '.') }}
                        </td>
                        <td class="table-body table-actions">
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
