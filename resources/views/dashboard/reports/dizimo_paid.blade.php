@extends('layouts.admin')

@section('title', 'Membros Dizimistas')

@section('content')

    <h1 class="text-2xl font-bold mb-6">
        Membros que contribuíram com Dízimo
    </h1>

    <p class="text-sm text-gray-500 mb-4">
        {{ \Carbon\Carbon::create()->month($filters['month'])->translatedFormat('F') }}
        / {{ $filters['year'] }}
    </p>
    {{--
    <div class="inline-block">
        <div>
            <p class="text-center my-2 font-semibold"> ACOES</p>
        </div>

        <div>
            <p class="text-center my-2 font-semibold"> EXPORTAR</p>

            <div class="flex gap-3 mb-4">
                <a href="{{ route('dizimos.export.paid.pdf', request()->query()) }}" class="btn-info">
                    PDF
                </a>

                <a href="{{ route('dizimos.export.paid.csv', request()->query()) }}" class="btn-warning">
                    CSV
                </a>
            </div>
        </div>
    </div> --}}

    <x-report.actions pdfRoute="dizimos.export.paid.pdf" csvRoute="dizimos.export.paid.csv" backRoute="dashboard.dizimo"
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
                    <th class="text-center py-2">Ordem</th>
                    <th class="text-left py-2">Membro</th>
                    <th class="text-center py-2">Data</th>
                    <th class="text-right py-2">Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr class="border-b last:border-0">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="py-2">{{ $member->name }}</td>
                        <td class="py-2 text-center">
                            @foreach ($member->donations as $donation)
                                <div>
                                    {{ $donation->donation_date->format('d/m/Y') }}
                                </div>
                            @endforeach
                        </td>
                        </td>
                        <td class="py-2 text-right text-green-600 font-semibold">
                            R$
                            {{ number_format($member->donations->sum('amount'), 2, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="py-4 text-center text-gray-500">
                            Nenhum registro encontrado.
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
