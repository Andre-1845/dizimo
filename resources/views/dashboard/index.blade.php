@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="w-full">
        <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

        <form method="GET" class="flex gap-2 mb-6">
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

            <button class="btn-primary">
                Filtrar
            </button>
        </form>


        {{-- CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

            {{-- Doações --}}
            <div class="bg-gray-100 border rounded-xl shadow p-6">
                <p class="text-sm text-gray-500">Receitas</p>
                <p class="text-2xl font-bold text-green-600">
                    R$ {{ number_format($totalDonations, 2, ',', '.') }}
                </p>
            </div>

            {{-- Despesas --}}
            <div class="bg-gray-100 border rounded-xl shadow p-6">
                <p class="text-sm text-gray-500">Despesas</p>
                <p class="text-2xl font-bold text-red-600">
                    R$ {{ number_format($totalExpenses, 2, ',', '.') }}
                </p>
            </div>

            {{-- Saldo --}}
            <div class="bg-gray-100 border rounded-xl shadow p-6">
                <p class="text-sm text-gray-500">Saldo</p>
                <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                    R$ {{ number_format($balance, 2, ',', '.') }}
                </p>

            </div>

            {{-- Membros --}}
            <div class="bg-gray-100 border rounded-xl text-center  shadow p-6">
                <p class="text-sm text-gray-500">Usuários Ativos</p>
                <p class="text-2xl font-bold text-gray-800">
                    {{ $usersActiveCount }}
                </p>
            </div>

        </div> {{-- FIM - Cards --}}

        {{-- Graficos CHART JS --}}

        <div class="bg-gray-50 rounded-xl shadow p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4">
                Receitas x Despesas — {{ $year }}
            </h2>

            <canvas id="donationsExpensesChart" height="120"></canvas>
        </div>

        <br>

        <div class="bg-gray-50 rounded-xl shadow p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4">
                Despesas por Categoria — {{ $year }}
            </h2>

            <div class="max-w-md mx-auto">
                <canvas id="expensesCategoryChart"></canvas>
            </div>
        </div>



        {{--  FIM Graficos --}}


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
            </div> {{-- FIM - Ultimas Doacoes --}}

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
            </div> {{-- FIM - Ultimas Despesas --}}

        </div> {{-- FIM - Listas --}}



        @push('scripts')
            {{-- Grafico de Barras --}}

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    if (typeof Chart === 'undefined') {
                        console.error('Chart.js não carregado');
                        return;
                    }

                    const donationsData = @json($donationsByMonth);
                    const expensesData = @json($expensesByMonth);

                    const labels = [
                        'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                        'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
                    ];

                    const donations = labels.map((_, index) => donationsData[index + 1] ?? 0);
                    const expenses = labels.map((_, index) => expensesData[index + 1] ?? 0);

                    const canvas = document.getElementById('donationsExpensesChart');

                    if (!canvas) {
                        console.error('Canvas do gráfico não encontrado');
                        return;
                    }

                    const ctx = canvas.getContext('2d');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Doações',
                                    data: donations,
                                    borderColor: '#16a34a',
                                    backgroundColor: 'rgba(22, 163, 74, 0.8)',
                                    borderRadius: 6,
                                    barThickness: 18,
                                },
                                {
                                    label: 'Despesas',
                                    data: expenses,
                                    borderColor: '#dc2626',
                                    backgroundColor: 'rgba(220, 38, 38, 0.8)',
                                    borderRadius: 6,
                                    barThickness: 18,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': R$ ' +
                                                context.parsed.y.toLocaleString('pt-BR');
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: value => 'R$ ' + value.toLocaleString('pt-BR')
                                    }
                                }
                            }
                        }
                    });

                });
            </script>

            {{--  Grafico Pizza --}}

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const expensesCategoryData = @json($expensesByCategory);

                    const categoryLabels = Object.keys(expensesCategoryData);
                    const categoryTotals = Object.values(expensesCategoryData);


                    const categoryColors = [
                        '#FF0000', '#006400', '#0000FF',
                        '#FFD700', '#4B0082', '#6366f1',
                        '#8b5cf6', '#00FF00', '#ADFF2F'
                    ];

                    const ctxCategory = document
                        .getElementById('expensesCategoryChart')
                        .getContext('2d');

                    new Chart(ctxCategory, {
                        type: 'pie',
                        data: {
                            labels: categoryLabels,
                            datasets: [{
                                data: categoryTotals,
                                backgroundColor: categoryColors.slice(0, categoryLabels.length),
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'left',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.label + ': R$ ' +
                                                context.parsed.toLocaleString('pt-BR');
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>

            {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {

                const dataByCategory = @json($expensesByCategory);

                const labels = Object.keys(dataByCategory);
                const values = Object.values(dataByCategory);

                const total = values.reduce((a, b) => a + b, 0);

                const ctx = document.getElementById('expensesByCategoryChart');
                if (!ctx) return;

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [
                                '#2563eb', '#16a34a', '#dc2626',
                                '#ca8a04', '#9333ea', '#0d9488'
                            ]
                        }]
                    },
                    options: {
                        plugins: {
                            datalabels: {
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                },
                                formatter: (value) => {
                                    const percent = ((value / total) * 100).toFixed(1);
                                    return percent + '%';
                                }
                            },
                            legend: {
                                position: 'right'
                            }
                        }
                    }
                });

            });
        </script> --}}
        @endpush

    </div>
@endsection
