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

    <div class="flex gap-3 mb-4">
        <button class="btn-secondary">PDF</button>
        <button class="btn-secondary">Excel</button>
    </div>

    <div class="bg-white rounded shadow p-4">

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Membro</th>
                    <th class="text-right py-2">Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr class="border-b last:border-0">
                        <td class="py-2">{{ $member->name }}</td>
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
