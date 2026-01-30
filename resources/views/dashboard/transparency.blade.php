@extends('layouts.admin')

@section('content')
    <div class="transparency-dashboard content-wrapper">

        {{-- Cabeçalho --}}
        <div class="content-header mb-4">
            <div>
                <h1 class="content-title">Transparência Financeira</h1>
                <p class="text-sm text-gray-500">
                    Acompanhe de forma clara como os recursos da igreja são utilizados.
                </p>
            </div>

            {{-- Filtros --}}
            <form method="GET" class="filter-box grid grid-cols-1 sm:grid-cols-2 gap-3 min-w-[260px]">
                <select name="year" onchange="this.form.submit()" class="form-input w-full">
                    @foreach ($availableYears as $availableYear)
                        <option value="{{ $availableYear }}" {{ $year == $availableYear ? 'selected' : '' }}>
                            {{ $availableYear }}
                        </option>
                    @endforeach
                </select>

                <select name="month" onchange="this.form.submit()" class="form-input w-full">
                    <option value="">Todos os meses</option>
                    @foreach ([1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'] as $num => $name)
                        <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Resumo financeiro --}}
        <div class="transparency-grid-3 mb-6">

            {{-- Receitas --}}
            <div class="transparency-summary transparency-income">
                <div>
                    <div class="transparency-summary-title">Receitas</div>
                    <div class="transparency-summary-value text-green-600">
                        R$ {{ number_format($totalIncome, 2, ',', '.') }}
                    </div>
                    <div class="transparency-summary-meta">
                        {{ $year }}{{ $month ? ' - ' . DateTime::createFromFormat('!m', $month)->format('F') : '' }}
                    </div>
                </div>
                <div class="icon-shape bg-green-500 text-white">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>

            {{-- Despesas --}}
            <div class="transparency-summary transparency-expense">
                <div>
                    <div class="transparency-summary-title">Despesas</div>
                    <div class="transparency-summary-value text-blue-600">
                        R$ {{ number_format($totalExpenses, 2, ',', '.') }}
                    </div>
                    <div class="transparency-summary-meta">
                        {{ $year }}{{ $month ? ' - ' . DateTime::createFromFormat('!m', $month)->format('F') : '' }}
                    </div>
                </div>
                <div class="icon-shape bg-blue-500 text-white">
                    <i class="fas fa-arrow-down"></i>
                </div>
            </div>

            {{-- Saldo --}}
            <div
                class="transparency-summary {{ $balance >= 0 ? 'transparency-balance-positive' : 'transparency-balance-negative' }}">
                <div>
                    <div class="transparency-summary-title">Saldo</div>
                    <div class="transparency-summary-value {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        R$ {{ number_format($balance, 2, ',', '.') }}
                    </div>
                    <div class="transparency-summary-meta">
                        {{ $balance >= 0 ? 'Superávit (sobrou no período)' : 'Déficit (gastou mais que arrecadou)' }}
                    </div>
                </div>
                <div class="icon-shape {{ $balance >= 0 ? 'bg-green-600' : 'bg-red-500' }} text-white">
                    <i class="fas fa-balance-scale"></i>
                </div>
            </div>
        </div>

        {{-- Gráfico --}}
        <div class="transparency-chart-card mb-6">
            <h6 class="transparency-chart-title">
                Evolução Mensal – {{ $year }}
            </h6>
            <canvas id="evolutionChart"></canvas>
        </div>

        {{-- Categorias --}}
        <div class="transparency-grid-2 mb-6">

            {{-- Receitas por categoria --}}
            <div class="content-box p-0">

                <div class="transparency-section-header transparency-section-income rounded-t-lg">
                    Receitas por Categoria
                </div>

                @if ($incomeByCategory->count())
                    <table class="table table-transparency w-full">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incomeByCategory as $category)
                                <tr>
                                    <td>
                                        <span class="color-indicator bg-green-500"></span>
                                        {{ $category->name }}
                                    </td>
                                    <td class="text-right">
                                        R$ {{ number_format($category->total, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        <span class="percent-badge">
                                            {{ $totalIncome > 0 ? number_format(($category->total / $totalIncome) * 100, 1) : 0 }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-pie"></i>
                        <p>Nenhuma receita registrada no período.</p>
                    </div>
                @endif
            </div>

            {{-- Despesas por categoria --}}
            <div class="content-box p-0">

                <div class="transparency-section-header transparency-section-expense rounded-t-lg">
                    Despesas por Categoria
                </div>

                @if ($expensesByCategory->count())
                    <table class="table table-transparency w-full">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expensesByCategory as $category)
                                <tr>
                                    <td>
                                        <span class="color-indicator bg-blue-500"></span>
                                        {{ $category->name }}
                                    </td>
                                    <td class="text-right">
                                        R$ {{ number_format($category->total, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        <span class="percent-badge">
                                            {{ $totalExpenses > 0 ? number_format(($category->total / $totalExpenses) * 100, 1) : 0 }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-pie"></i>
                        <p>Nenhuma despesa registrada no período.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Relatórios --}}
        <div class="content-box">
            <div class="content-box-header">
                <div>
                    <h3 class="content-box-title">Relatórios e Documentos</h3>
                    <p class="text-sm text-gray-500">Documentos disponíveis para consulta</p>
                </div>
            </div>

            @if ($reports->count())
                <div class="transparency-grid-3">
                    @foreach ($reports as $report)
                        <div class="report-card">
                            <div>
                                <h4 class="report-title">{{ $report->title }}</h4>
                                <p class="report-desc">
                                    {{ Str::limit($report->description, 120) }}
                                </p>
                            </div>

                            <div class="report-footer">
                                <a href="{{ $report->file_url }}" target="_blank" class="btn-primary">
                                    <i class="fas fa-file-pdf"></i> Abrir PDF
                                </a>
                                <span>{{ $report->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-file-pdf"></i>
                    <p>Nenhum relatório disponível no momento.</p>
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Evolução
        const ctx = document.getElementById('evolutionChart').getContext('2d');
        const labels = {!! json_encode(array_column($monthlyData, 'month')) !!};
        const incomeData = {!! json_encode(array_column($monthlyData, 'income')) !!};
        const expenseData = {!! json_encode(array_column($monthlyData, 'expenses')) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Receitas',
                        data: incomeData,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.05)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Despesas',
                        data: expenseData,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.05)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                        },
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>


@endsection
