<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Expense;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         $month = now()->month;
//         $year  = now()->year;

//         return view('dashboard.index', [
//             'menu' => 'dashboard',

//             'totalDonations' => Donation::whereMonth('donation_date', $month)
//                 ->whereYear('donation_date', $year)
//                 ->sum('amount'),

//             'totalExpenses' => Expense::whereMonth('expense_date', $month)
//                 ->whereYear('expense_date', $year)
//                 ->sum('amount'),

//             'membersCount' => Member::count(),
//         ]);
//     }
// }

class DashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth   = now()->endOfMonth();

        // Totais do mês
        $totalDonationsMonth = Donation::whereBetween('donation_date', [
            $startOfMonth,
            $endOfMonth,
        ])->sum('amount');

        $totalExpensesMonth = Expense::whereBetween('expense_date', [
            $startOfMonth,
            $endOfMonth,
        ])->sum('amount');

        // Saldo
        $balanceMonth = $totalDonationsMonth - $totalExpensesMonth;

        // Total de membros
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

        return view('dashboard.index', [
            'menu' => 'dashboard',

            'totalDonationsMonth' => $totalDonationsMonth,
            'totalExpensesMonth'  => $totalExpensesMonth,
            'balanceMonth'        => $balanceMonth,
            'membersCount'        => $membersCount,

            'lastDonations' => $lastDonations,
            'lastExpenses'  => $lastExpenses,
        ]);
    }
}
