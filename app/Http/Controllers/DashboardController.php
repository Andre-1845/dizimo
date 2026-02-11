<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Expense;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $year = (int) $request->get('year', now()->year);

        $month = $request->filled('month') ? $request->month : null;


        /* =====================
     |  TOTAIS (CARDS)
     ===================== */

        $donationsQuery = Donation::confirmed()
            ->whereYear('donation_date', $year);
        $expensesQuery  = Expense::approved()
            ->whereYear('expense_date', $year);

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
        $usersActiveCount = User::active()->count();
        $usersPendingCount = User::pending()->count();
        $membersCount = Member::count();
        $membersActiveCount = Member::active()->count();

        $membersInactiveCount = ($membersCount - $membersActiveCount);

        /* =====================
     |  ÚLTIMOS REGISTROS
     ===================== */

        $lastDonations = Donation::confirmed()
            ->with('member')
            ->orderByDesc('donation_date')
            ->limit(10)
            ->get();

        $lastExpenses = Expense::approved()
            ->with('category')
            ->orderByDesc('expense_date')
            ->limit(10)
            ->get();

        /* =====================
     |  GRÁFICO LINHA
     |  Doações x Despesas
     ===================== */

        $donationsByMonth = Donation::confirmed()
            ->selectRaw('MONTH(donation_date) as month, SUM(amount) as total')
            ->whereYear('donation_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $expensesByMonth = Expense::approved()
            ->selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
            ->whereYear('expense_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        /* =====================
     |  GRÁFICO BARRAS
     |  Doações por categoria
     ===================== */

        $expensesByCategoryQuery = Expense::approved()
            ->join('categories', 'categories.id', '=', 'expenses.category_id')
            ->selectRaw('categories.name as category, SUM(expenses.amount) as total')
            ->whereYear('expenses.expense_date', $year);

        if ($month) {
            $expensesByCategoryQuery->whereMonth('expenses.expense_date', $month);
        }

        $expensesByCategory = $expensesByCategoryQuery
            ->groupBy('categories.name')
            ->pluck('total', 'category');


        $availableYears = Donation::confirmed()
            ->selectRaw('YEAR(donation_date) as year')
            ->union(
                Expense::approved()
                    ->selectRaw('YEAR(expense_date) as year')
            )
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        /* =====================
     |  RETURN
     ===================== */

        return view('dashboard.index', [
            'year' => $year,
            'month' => $month,
            'availableYears' => $availableYears,


            // Cards
            'totalDonations' => $totalDonations,
            'totalExpenses'  => $totalExpenses,
            'balance'        => $balance,
            'membersCount'   => $membersCount,
            'membersActiveCount' => $membersActiveCount,
            'membersInactiveCount' => $membersInactiveCount,
            'usersActiveCount' => $usersActiveCount,
            'usersPendingCount' => $usersPendingCount,


            // Listas
            'lastDonations' => $lastDonations,
            'lastExpenses'  => $lastExpenses,

            // Gráficos
            'donationsByMonth'    => $donationsByMonth,
            'expensesByMonth'     => $expensesByMonth,
            // 'donationsByCategory' => $donationsByCategory,
            'expensesByCategory' => $expensesByCategory,

        ]);
    }

    // **************    MEMBER DASHBOARD   ****************

    public function member(Request $request)
    {
        $year  = $request->get('year', now()->year);
        $month = $request->filled('month') ? $request->month : null;

        // Doações
        $donationsQuery = Donation::confirmed()
            ->whereYear('donation_date', $year);
        if ($month) {
            $donationsQuery->whereMonth('donation_date', $month);
        }
        $totalDonations = $donationsQuery->sum('amount');

        // Despesas
        $expensesQuery = Expense::approved()
            ->whereYear('expense_date', $year);
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

        $myDonations = $myDonationsQuery->paginate(10);

        // Despesas por categoria (agrupado)
        $expensesByCategory = Expense::approved()
            ->selectRaw('categories.name, SUM(expenses.amount) as total')
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
