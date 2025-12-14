<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Expense;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year  = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // Totais do mês
        $totalDonationsMonth = Donation::whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->sum('amount');

        $totalExpensesMonth = Expense::whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->sum('amount');

        $balanceMonth = $totalDonationsMonth - $totalExpensesMonth;

        // Quantidade de membros
        $membersCount = Member::count();

        // Últimas doações
        $lastDonations = Donation::with('member')
            ->orderByDesc('donation_date')
            ->limit(5)
            ->get();

        // Últimas despesas
        $lastExpenses = Expense::with('category')
            ->orderByDesc('expense_date')
            ->limit(5)
            ->get();

        // Gráfico: entradas x saídas (12 meses)
        $monthlyData = Donation::select(
            DB::raw('MONTH(donation_date) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->whereYear('donation_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyExpenses = Expense::select(
            DB::raw('MONTH(expense_date) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->whereYear('expense_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        return view('dashboard.index', compact(
            'totalDonationsMonth',
            'totalExpensesMonth',
            'balanceMonth',
            'membersCount',
            'lastDonations',
            'lastExpenses',
            'monthlyData',
            'monthlyExpenses',
            'year',
            'month'
        ));
    }
}
