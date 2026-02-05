<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Expense;
use App\Models\Category;
use App\Models\FinancialReport;
use App\Models\Report;
use App\Support\DateExtract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransparencyDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Apenas usuários logados
        // if (!Auth::check()) {
        //     abort(403, 'Acesso não autorizado.');
        // }

        // dd('TranparencyDashboardController');

        // Filtros
        $year = $request->get('year', now()->year);
        $month = $request->get('month'); // null = todos os meses

        // =====================
        // 1. TOTAIS GERAIS
        // =====================

        // Receitas totais do ano
        $totalIncome = Donation::confirmed()
            ->whereYear('donation_date', $year)
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('donation_date', $month);
            })
            ->sum('amount');

        // Despesas totais do ano
        $totalExpenses = Expense::approved()
            ->whereYear('expense_date', $year)
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('expense_date', $month);
            })
            ->sum('amount');

        // Saldo
        $balance = $totalIncome - $totalExpenses;

        // =====================
        // 2. RECEITAS POR CATEGORIA
        // =====================
        $incomeByCategory = Category::where('type', 'income')
            ->withSum(['donations as total' => function ($query) use ($year, $month) {
                $query->confirmed()
                    ->whereYear('donation_date', $year)
                    ->when($month, function ($q) use ($month) {
                        return $q->whereMonth('donation_date', $month);
                    });
            }], 'amount')
            ->orderByDesc('total')
            ->get()
            ->filter(fn($category) => ($category->total ?? 0) > 0)
            ->values();

        // =====================
        // 3. DESPESAS POR CATEGORIA
        // =====================
        $expensesByCategory = Category::where('type', 'expense')
            ->withSum(['expenses as total' => function ($query) use ($year, $month) {
                $query->approved()
                    ->whereYear('expense_date', $year)
                    ->when($month, function ($q) use ($month) {
                        return $q->whereMonth('expense_date', $month);
                    });
            }], 'amount')
            ->orderByDesc('total')
            ->get()
            ->filter(fn($category) => ($category->total ?? 0) > 0)
            ->values();

        // =====================
        // 4. EVOLUÇÃO MENSAL
        // =====================
        $monthlyData = [];
        $monthNames = [
            1 => 'Jan',
            2 => 'Fev',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'Mai',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Set',
            10 => 'Out',
            11 => 'Nov',
            12 => 'Dez'
        ];

        for ($m = 1; $m <= 12; $m++) {
            $monthIncome = Donation::confirmed()
                ->whereYear('donation_date', $year)
                ->whereMonth('donation_date', $m)
                ->sum('amount');

            $monthExpense = Expense::approved()
                ->whereYear('expense_date', $year)
                ->whereMonth('expense_date', $m)
                ->sum('amount');

            $monthlyData[] = [
                'month' => $monthNames[$m],
                'income' => $monthIncome,
                'expenses' => $monthExpense,
                'balance' => $monthIncome - $monthExpense,
            ];
        }

        // =====================
        // 5. RELATÓRIOS ATIVOS
        // =====================
        // $reports = Report::active()
        //     ->orderByDesc('created_at')
        //     ->limit(6) // Mostra até 6 relatórios
        //     ->get();

        $reports = FinancialReport::public()
            // ->type('financial')
            ->orderByDesc('reference_month')
            ->get();

        // =====================
        // 6. ANOS DISPONÍVEIS
        // =====================
        $availableYears = Donation::selectRaw(
            DateExtract::year('donation_date') . ' as year'
        )
            ->union(
                Expense::selectRaw(
                    DateExtract::year('expense_date') . ' as year'
                )
            )
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('dashboard.transparency', [
            'year' => $year,
            'month' => $month,
            'availableYears' => $availableYears,

            // Totais
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'balance' => $balance,

            // Categorias
            'incomeByCategory' => $incomeByCategory,
            'expensesByCategory' => $expensesByCategory,

            // Gráfico
            'monthlyData' => $monthlyData,

            // Relatórios
            'reports' => $reports,

            // Menu
            'menu' => 'transparency',
        ]);
    }
}