<div>
    @extends('layouts.admin')

    @section('title', 'Controle de Dízimos')

    @section('content')

        <h1 class="text-2xl font-bold mb-6">Dashboard de Dízimos</h1>

        {{-- FILTRO --}}
        <form method="GET" class="flex flex-wrap gap-3 mb-6 items-end">
            <select name="month" class="border rounded p-2">
                <option value="">Todos os meses</option>
                <option value="">Mês</option>
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" @selected($month == $m)>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <select name="year" class="border rounded p-2">
                @for ($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
                @endfor
            </select>

            <select name="per_page" class="border rounded p-2">
                @foreach ([10, 20, 50, 100] as $size)
                    <option value="{{ $size }}" @selected(request('per_page', 10) == $size)>
                        {{ $size }} por página
                    </option>
                @endforeach
            </select>

            <button class="btn-primary">Filtrar</button>
        </form>


        {{-- CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">

            <div class="bg-white rounded shadow p-4">
                <p class="text-sm text-gray-500">Dízimo Previsto (mensal)</p>
                <p class="text-xl font-bold text-blue-600">
                    R$ {{ number_format($totalExpected, 2, ',', '.') }}
                </p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <p class="text-sm text-gray-500">Dízimo Arrecadado (mensal)</p>
                <p class="text-xl font-bold text-green-600">
                    R$ {{ number_format($totalCollected, 2, ',', '.') }}
                </p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <p class="text-sm text-gray-500">Dízimo em Falta (mensal)</p>
                <p class="text-xl font-bold text-red-600">
                    R$ {{ number_format($totalMissing, 2, ',', '.') }}
                </p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <p class="text-sm text-gray-500">Percentual Cumprido (mensal)</p>
                <p class="text-xl font-bold {{ $percentageCollected >= 100 ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ $percentageCollected }}%
                </p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <p class="text-sm text-gray-500">Dízimo Arrecadado no Ano</p>
                <p class="text-xl font-bold text-violet-800">
                    R$ {{ number_format($totalCollectedYear, 2, ',', '.') }}
                </p>
            </div>

        </div>

        {{-- TABELAS --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">

            {{-- PAGARAM --}}
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold mb-4 text-green-700">Membros em dia</h2>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Membro</th>
                            <th class="text-right py-2">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($membersWithTithe as $member)
                            <tr class="border-b last:border-0">
                                <td class="py-2">{{ $member->name }}</td>
                                <td class="py-2 text-right text-green-600 font-semibold">
                                    R$ {{ number_format($member->donations->sum('amount'), 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500">
                                    Nenhum membro em dia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4 w-full flex justify-center">
                    {{ $membersWithTithe->links() }}
                </div>

            </div>

            {{-- NÃO PAGARAM --}}
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold mb-4 text-red-700">Membros inadimplentes</h2>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Membro</th>
                            <th class="text-right py-2">Previsto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($membersWithoutTithe as $member)
                            <tr class="border-b last:border-0">
                                <td class="py-2">{{ $member->name }}</td>
                                <td class="py-2 text-right text-red-600 font-semibold">
                                    R$ {{ number_format($member->monthly_tithe, 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500">
                                    Nenhum inadimplente 🎉
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4 w-full flex justify-center">
                    {{ $membersWithoutTithe->links() }}
                </div>
            </div>

        </div>

        {{-- GRÁFICO (placeholder) --}}
        <div class="bg-white rounded shadow p-6">
            <h2 class="font-semibold mb-4">Evolução anual do dízimo</h2>

            <canvas id="titheByMonthChart" height="120"></canvas>
        </div>

    @endsection

</div>
