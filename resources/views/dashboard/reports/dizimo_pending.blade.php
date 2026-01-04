@extends('layouts.admin')

@section('title', 'Doações Pendentes')

@section('content')

    <h1 class="text-2xl font-bold mb-6">
        Membros com Dízimo Pendente
    </h1>

    <p class="text-sm text-gray-500 mb-4">
        {{ \Carbon\Carbon::create()->month($filters['month'])->translatedFormat('F') }}
        / {{ $filters['year'] }}
    </p>

    {{-- AÇÕES --}}
    <x-report.actions pdfRoute="dizimos.export.pending.pdf" csvRoute="dizimos.export.pending.csv" backRoute="dashboard.dizimo"
        :params="[
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
                    <th>Ordem</th>
                    <th class="text-left py-2">Membro</th>
                    <th class="text-right py-2">Valor Previsto</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr class="border-b last:border-0">
                        <td class="text-center"> {{ $members->firstItem() + $loop->index }}</td>
                        <td class="py-2">{{ $member->name }}</td>
                        <td class="py-2 text-right text-red-600 font-semibold">
                            R$ {{ money($member->monthly_tithe) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="py-4 text-center text-gray-500">
                            Nenhum membro pendente encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $members->links() }}
        </div>

    </div>

@endsection
