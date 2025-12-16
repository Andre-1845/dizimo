<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Expense;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year  = $request->get('year', now()->year);
        $month = $request->filled('month') ? $request->month : null;

        // Doacoes

        $totalDonationsQuery = Donation::whereYear('donation_date', $year);

        if ($month) {
            $totalDonationsQuery->whereMonth('donation_date', $month);
        }

        $totalDonations = $totalDonationsQuery->sum('amount');

        // Despesas
        $expensesQuery = Expense::whereYear('expense_date', $year);
        if ($month) {
            $expensesQuery->whereMonth('expense_date', $month);
        }
        $totalExpenses = $expensesQuery->sum('amount');

        // TOTAL do PERIODO

        $balance = $totalDonations - $totalExpenses;

        // Quantidade de membros
        $membersCount = Member::count();

        // Últimas doações
        $lastDonations = Donation::with('member')
            ->orderByDesc('donation_date')
            ->limit(10)
            ->get();

        // Últimas despesas
        $lastExpenses = Expense::with('category')
            ->orderByDesc('expense_date')
            ->limit(10)
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
            'totalDonations',
            'totalExpenses',
            'membersCount',
            'lastDonations',
            'balance',
            'lastExpenses',
            'monthlyData',
            'monthlyExpenses',
            'year',
            'month'
        ));
    }

    public function member(Request $request)
    {
        $year  = $request->get('year', now()->year);
        $month = $request->filled('month') ? $request->month : null;

        // Doações
        $donationsQuery = Donation::whereYear('donation_date', $year);
        if ($month) {
            $donationsQuery->whereMonth('donation_date', $month);
        }
        $totalDonations = $donationsQuery->sum('amount');

        // Despesas
        $expensesQuery = Expense::whereYear('expense_date', $year);
        if ($month) {
            $expensesQuery->whereMonth('expense_date', $month);
        }
        $totalExpenses = $expensesQuery->sum('amount');

        // Balanço

        $balance = $totalDonations - $totalExpenses;

        // Histórico do membro
        $myDonationsQuery = Donation::where('member_id', Auth::id())
            ->whereYear('donation_date', $year);

        if ($month) {
            $myDonationsQuery->whereMonth('donation_date', $month);
        }

        $myDonations = $myDonationsQuery->paginate(5);

        // Despesas por categoria (agrupado)
        $expensesByCategory = Expense::selectRaw('categories.name, SUM(expenses.amount) as total')
            ->join('categories', 'categories.id', '=', 'expenses.category_id')
            ->whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->groupBy('categories.name')
            ->get();

        // Doações do próprio membro
        $myDonations = Donation::where('member_id', Auth::user()->member->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->orderByDesc('donation_date')
            ->paginate(10);


        return view('dashboard.member', compact(
            'totalDonations',
            'totalExpenses',
            'balance',
            'expensesByCategory',
            'myDonations',
            'year',
            'month'
        ));
    }
}
