<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Donation;
use App\Models\Category;

class DizimoDashboardController extends Controller
{
    public function index(Request $request)
    {

        // dd($request->query());

        // ===============================
        // 1. Filtros
        // ===============================
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        // ===============================
        // 2. Categoria DÍZIMO
        // ===============================
        $dizimoCategory = Category::where('name', 'Dízimo')->firstOrFail();

        // ===============================
        // 3. Total PREVISTO (membros ativos)
        // ===============================
        $totalExpected = Member::where('active', true)
            ->sum('monthly_tithe');

        // ===============================
        // 4. Total ARRECADADO (mês e ano)
        // ===============================
        $totalCollected = Donation::where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->sum('amount');

        $totalCollectedYear = Donation::where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->sum('amount');

        // ===============================
        // 5. Total EM FALTA
        // ===============================
        $totalMissing = max(0, $totalExpected - $totalCollected);

        // ===============================
        // 6. Percentuais
        // ===============================
        $percentageCollected = $totalExpected > 0
            ? round(($totalCollected / $totalExpected) * 100, 2)
            : 0;

        // ===============================
        // 7. Cards OPERACIONAIS
        // ===============================

        // Membros que pagaram
        $membersPaidCount = Member::where('active', true)
            ->whereHas('donations', function ($q) use ($year, $month, $dizimoCategory) {
                $q->where('category_id', $dizimoCategory->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            })
            ->count();

        $membersPaidTotal = Donation::whereNotNull('member_id')
            ->where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->sum('amount');

        // Membros pendentes
        $membersPendingCount = Member::where('active', true)
            ->whereDoesntHave('donations', function ($q) use ($year, $month, $dizimoCategory) {
                $q->where('category_id', $dizimoCategory->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            })
            ->count();

        $membersPendingTotal = Member::where('active', true)
            ->whereDoesntHave('donations', function ($q) use ($year, $month, $dizimoCategory) {
                $q->where('category_id', $dizimoCategory->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            })
            ->sum('monthly_tithe');

        // Doações anônimas / administração
        $anonymousCount = Donation::whereNull('member_id')
            ->where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->count();

        $anonymousTotal = Donation::whereNull('member_id')
            ->where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->sum('amount');

        // ===============================
        // 8. Retorno da view
        // ===============================
        return view('dashboard.dizimo_index', compact(
            'year',
            'month',
            'totalExpected',
            'totalCollected',
            'totalCollectedYear',
            'totalMissing',
            'percentageCollected',
            'membersPaidCount',
            'membersPaidTotal',
            'membersPendingCount',
            'membersPendingTotal',
            'anonymousCount',
            'anonymousTotal'
        ) + ['menu' => 'dashboard-dizimo']);
    }
}
