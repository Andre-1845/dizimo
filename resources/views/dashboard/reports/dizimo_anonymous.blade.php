@extends('layouts.admin')

@section('title', 'Doações Administrativas')

@section('content')

    <h1 class="text-2xl font-bold mb-6">
        Doações Administrativas / Anônimas
    </h1>

    <p class="text-sm text-gray-500 mb-4">
        {{ \Carbon\Carbon::create()->month($filters['month'])->translatedFormat('F') }}
        / {{ $filters['year'] }}
    </p>

    {{-- AÇÕES --}}
    <x-report.actions pdfRoute="dizimos.export.anonymous.pdf" csvRoute="dizimos.export.anonymous.csv"
        backRoute="dashboard.dizimo" :params="[
            'month' => request('month'),
            'year' => request('year'),
        ]">

        {{-- Futuro --}}
        {{-- <a class="btn-primary">Outro botão</a> --}}
    </x-report.actions>

    <div class="bg-white rounded shadow p-4">

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-center py-2">Ordem</th>
                    <th class="text-left py-2">Origem</th>
                    <th class="text-left py-2">Data</th>
                    <th class="text-right py-2">Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($donations as $donation)
                    <tr class="border-b last:border-0">
                        <td class="text-center"> {{ $donations->firstItem() + $loop->index }}</td>
                        <td class="py-2">
                            {{ $donation->donor_name ?? 'Administração' }}
                        </td>
                        <td class="py-2">
                            {{ \Carbon\Carbon::parse($donation->donation_date)->format('d/m/Y') }}
                        </td>
                        <td class="py-2 text-right text-blue-600 font-semibold">
                            R$ {{ money($donation->amount) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500">
                            Nenhuma doação administrativa encontrada.
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
