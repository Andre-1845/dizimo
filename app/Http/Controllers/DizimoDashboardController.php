<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Donation;
use App\Models\Category;
use App\Models\Church;
use Carbon\Carbon;

class DizimoDashboardController extends Controller
{
    public function index(Request $request)
    {
        $church = Church::find(session('view_church_id'));


        // ===============================
        // 1. Filtros
        // ===============================
        $year  = (int) $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        if ($month) {
            $referenceDate = Carbon::create($year, $month, 1)->endOfMonth();
        } else {
            $referenceDate = Carbon::create($year, 12, 31);
        }

        $eligibleMembers = Member::active()
            ->existingUntil($referenceDate);


        /* =====================
     |  CONTADORES
     ===================== */

        $validMembers = Member::existingUntil($referenceDate);

        $membersCount = (clone $validMembers)->count();

        $membersActiveCount = (clone $validMembers)
            ->active()
            ->count();

        $membersInactiveCount = ($membersCount - $membersActiveCount);

        // ===============================
        // 2. Categoria DÍZIMO
        // ===============================
        $dizimoCategory = Category::where('name', 'Dízimo')->firstOrFail();

        // ===============================
        // 3. Total PREVISTO (membros ativos)
        // ===============================
        $totalExpected = (clone $eligibleMembers)
            ->sum('monthly_tithe');

        // ===============================
        // 4. Total ARRECADADO (mês e ano)
        // ===============================
        $totalCollected = Donation::confirmed()
            ->where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->sum('amount');

        $totalCollectedYear = Donation::confirmed()
            ->where('category_id', $dizimoCategory->id)
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
        $membersPaidCount = Member::whereHas('donations', function ($q) use ($year, $month, $dizimoCategory) {
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

        $donationsNotConfirmed = Donation::where('is_confirmed', false)
            ->where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->count();

        // Membros pendentes
        $membersPendingCount = (clone $eligibleMembers)
            ->whereDoesntHave('donations', function ($q) use ($year, $month, $dizimoCategory) {
                $q->where('category_id', $dizimoCategory->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            })
            ->count();

        $membersPendingTotal = (clone $eligibleMembers)
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

        $anonymousTotal = Donation::confirmed()
            ->whereNull('member_id')
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
            'membersCount',
            'membersActiveCount',
            'membersInactiveCount',
            'totalExpected',
            'totalCollected',
            'totalCollectedYear',
            'totalMissing',
            'percentageCollected',
            'membersPaidCount',
            'membersPaidTotal',
            'donationsNotConfirmed',
            'membersPendingCount',
            'membersPendingTotal',
            'anonymousCount',
            'anonymousTotal',
            'church',
        ) + ['menu' => 'dashboard-dizimo']);
    }
}
