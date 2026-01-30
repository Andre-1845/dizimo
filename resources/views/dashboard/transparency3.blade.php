@extends('layouts.admin')

@section('content')
    <div class="transparency-dashboard">
        <div class="content-wrapper">
            <!-- Cabeçalho -->
            <div class="row mb-4 align-items-center">
                <div class="content-header">
                    <h1 class="h3 mb-2">Transparência Financeira</h1>
                    <p class="text-muted mb-0">Acompanhe as receitas e despesas da comunidade.</p>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body py-2">
                            <form method="GET" class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                                        @foreach ($availableYears as $availableYear)
                                            <option value="{{ $availableYear }}"
                                                {{ $year == $availableYear ? 'selected' : '' }}>
                                                {{ $availableYear }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="">Todos os meses</option>
                                        @foreach ([
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ] as $num => $name)
                                            <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards de Totais -->
            <div class="transparency-grid-3">
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-start border-4 border-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-1">Receitas</h6>
                                    <h3 class="mb-0 text-success">R$ {{ number_format($totalIncome, 2, ',', '.') }}</h3>
                                </div>
                                <div class="icon-shape bg-success text-white rounded-circle p-2">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                            </div>
                            <p class="text-muted mt-2 mb-0 small">
                                {{ $year }}{{ $month ? ' - ' . DateTime::createFromFormat('!m', $month)->format('F') : '' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-start border-4 border-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-1">Despesas</h6>
                                    <h3 class="mb-0 text-primary">R$ {{ number_format($totalExpenses, 2, ',', '.') }}</h3>
                                </div>
                                <div class="icon-shape bg-primary text-white rounded-circle p-2">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                            </div>
                            <p class="text-muted mt-2 mb-0 small">
                                {{ $year }}{{ $month ? ' - ' . DateTime::createFromFormat('!m', $month)->format('F') : '' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-start border-4 {{ $balance >= 0 ? 'border-success' : 'border-danger' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-1">Saldo</h6>
                                    <h3 class="mb-0 {{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                        R$ {{ number_format($balance, 2, ',', '.') }}
                                    </h3>
                                </div>
                                <div
                                    class="icon-shape {{ $balance >= 0 ? 'bg-success' : 'bg-danger' }} text-white rounded-circle p-2">
                                    <i class="fas fa-balance-scale"></i>
                                </div>
                            </div>
                            <p class="text-muted mt-2 mb-0 small">
                                {{ $balance >= 0 ? 'Superávit' : 'Déficit' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Evolução -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="transparency-chart-card">
                        <h6 class="transparency-chart-title">Evolução Mensal - {{ $year }}</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="evolutionChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quadros de Categorias -->
        <div class="row mb-4">
            <!-- Receitas por Categoria -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold">Receitas por Categoria</h6>
                    </div>
                    <div class="card-body">
                        @if ($incomeByCategory->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Categoria</th>
                                            <th class="text-end">Total</th>
                                            <th class="text-end" style="width: 80px;">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($incomeByCategory as $category)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="color-indicator bg-success me-2"
                                                            style="width: 12px; height: 12px; border-radius: 2px;">
                                                        </div>
                                                        {{ $category->name }}
                                                    </div>
                                                </td>
                                                <td class="text-end">R$
                                                    {{ number_format($category->total, 2, ',', '.') }}
                                                </td>
                                                <td class="text-end">
                                                    <span class="badge bg-light text-dark">
                                                        {{ $totalIncome > 0 ? number_format(($category->total / $totalIncome) * 100, 1) : 0 }}%
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td class="text-end"><strong>R$
                                                    {{ number_format($totalIncome, 2, ',', '.') }}</strong></td>
                                            <td class="text-end"><strong>100%</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="empty-state-icon mb-3">
                                    <i class="fas fa-chart-pie fa-2x text-muted"></i>
                                </div>
                                <p class="text-muted mb-0">Nenhuma receita registrada no período.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Despesas por Categoria -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Despesas por Categoria</h6>
                    </div>
                    <div class="card-body">
                        @if ($expensesByCategory->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Categoria</th>
                                            <th class="text-end">Total</th>
                                            <th class="text-end" style="width: 80px;">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expensesByCategory as $category)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="color-indicator bg-primary me-2"
                                                            style="width: 12px; height: 12px; border-radius: 2px;">
                                                        </div>
                                                        {{ $category->name }}
                                                    </div>
                                                </td>
                                                <td class="text-end">R$
                                                    {{ number_format($category->total, 2, ',', '.') }}
                                                </td>
                                                <td class="text-end">
                                                    <span class="badge bg-light text-dark">
                                                        {{ $totalExpenses > 0 ? number_format(($category->total / $totalExpenses) * 100, 1) : 0 }}%
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td class="text-end"><strong>R$
                                                    {{ number_format($totalExpenses, 2, ',', '.') }}</strong></td>
                                            <td class="text-end"><strong>100%</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="empty-state-icon mb-3">
                                    <i class="fas fa-chart-pie fa-2x text-muted"></i>
                                </div>
                                <p class="text-muted mb-0">Nenhuma despesa registrada no período.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção de Relatórios -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Relatórios e Documentos</h6>
                        <p class="text-muted mb-0 small">Documentos disponíveis para consulta</p>
                    </div>
                    <div class="card-body">
                        @if ($reports->count() > 0)
                            <div class="row">
                                @foreach ($reports as $report)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border">
                                            <div class="card-body d-flex flex-column">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-0">{{ $report->title }}</h6>
                                                    @if ($report->available_until)
                                                        <small class="text-muted">
                                                            <i class="far fa-calendar-alt me-1"></i>
                                                            {{ $report->available_until->format('d/m/Y') }}
                                                        </small>
                                                    @endif
                                                </div>

                                                @if ($report->description)
                                                    <p class="card-text small text-muted flex-grow-1">
                                                        {{ Str::limit($report->description, 120) }}
                                                    </p>
                                                @endif

                                                <div class="mt-auto">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <a href="{{ $report->file_url }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-file-pdf me-1"></i> Abrir PDF
                                                        </a>
                                                        <small class="text-muted">
                                                            {{ $report->created_at->format('d/m/Y') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if (auth()->user()->hasRole('admin'))
                                <div class="text-center mt-4">
                                    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-cog me-1"></i> Gerenciar Relatórios
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <div class="empty-state-icon mb-3">
                                    <i class="fas fa-file-pdf fa-3x text-muted"></i>
                                </div>
                                <h6 class="text-muted mb-2">Nenhum relatório disponível</h6>
                                <p class="text-muted small">Novos relatórios serão publicados em breve.</p>

                                @if (auth()->user()->hasRole('admin'))
                                    <a href="{{ route('reports.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-plus me-1"></i> Adicionar Relatório
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
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

    <style>
        /* Estilos mínimos - compatível com Bootstrap */
        .color-indicator {
            display: inline-block;
        }

        .icon-shape {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state-icon {
            opacity: 0.5;
        }

        .card {
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
        }

        .card-header:first-child {
            border-radius: 0.35rem 0.35rem 0 0;
        }

        .table-sm th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #6c757d;
        }

        .border-start {
            border-left-width: 4px !important;
        }

        /* Ajustes para responsividade */
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            h3 {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection
