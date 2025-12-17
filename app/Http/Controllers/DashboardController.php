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

        /* =====================
     |  TOTAIS (CARDS)
     ===================== */

        $donationsQuery = Donation::whereYear('donation_date', $year);
        $expensesQuery  = Expense::whereYear('expense_date', $year);

        if ($month) {
            $donationsQuery->whereMonth('donation_date', $month);
            $expensesQuery->whereMonth('expense_date', $month);
        }

        $totalDonations = $donationsQuery->sum('amount');
        $totalExpenses  = $expensesQuery->sum('amount');
        $balance        = $totalDonations - $totalExpenses;

        /* =====================
     |  CONTADORES
     ===================== */

        $membersCount = Member::count();

        /* =====================
     |  ÚLTIMOS REGISTROS
     ===================== */

        $lastDonations = Donation::with('member')
            ->orderByDesc('donation_date')
            ->limit(10)
            ->get();

        $lastExpenses = Expense::with('category')
            ->orderByDesc('expense_date')
            ->limit(10)
            ->get();

        /* =====================
     |  GRÁFICO LINHA
     |  Doações x Despesas
     ===================== */

        $donationsByMonth = Donation::selectRaw('MONTH(donation_date) as month, SUM(amount) as total')
            ->whereYear('donation_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $expensesByMonth = Expense::selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
            ->whereYear('expense_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        /* =====================
     |  GRÁFICO BARRAS
     |  Doações por categoria
     ===================== */

        $donationsByCategory = Donation::join('categories', 'categories.id', '=', 'donations.category_id')
            ->selectRaw('categories.name as category, SUM(donations.amount) as total')
            ->groupBy('categories.name')
            ->pluck('total', 'category');

        $expensesByCategory = Expense::join('categories', 'categories.id', '=', 'expenses.category_id')
            ->selectRaw('categories.name as category, SUM(expenses.amount) as total')
            ->groupBy('categories.name')
            ->pluck('total', 'category');


        /* =====================
     |  RETURN
     ===================== */

        return view('dashboard.index', [
            'year' => $year,
            'month' => $month,

            // Cards
            'totalDonations' => $totalDonations,
            'totalExpenses'  => $totalExpenses,
            'balance'        => $balance,
            'membersCount'   => $membersCount,

            // Listas
            'lastDonations' => $lastDonations,
            'lastExpenses'  => $lastExpenses,

            // Gráficos
            'donationsByMonth'    => $donationsByMonth,
            'expensesByMonth'     => $expensesByMonth,
            'donationsByCategory' => $donationsByCategory,
            'expensesByCategory' => $expensesByCategory,

        ]);
    }

    // **************    MEMBER DASHBOARD   ****************

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
