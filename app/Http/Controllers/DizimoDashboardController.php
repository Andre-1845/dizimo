<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Donation;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DizimoDashboardController extends Controller
{

    public function index(Request $request)
    {
        // ===============================
        // 1. Filtros
        // ===============================
        $year  = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // ===============================
        // 2. Categoria DÍZIMO
        // ===============================
        $dizimoCategory = Category::where('name', 'Dízimo')->firstOrFail();
        // se preferir slug:
        // Category::where('slug', 'dizimo')->firstOrFail();

        // ===============================
        // 3. Total PREVISTO (membros ativos)
        // ===============================
        $totalExpected = Member::where('active', true)
            ->sum('monthly_tithe');

        // ===============================
        // 4. Total ARRECADADO no mês
        // ===============================
        $totalCollected = Donation::where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
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

        $percentageMissing = 100 - $percentageCollected;

        // ===============================
        // 7. Membros que PAGARAM o dízimo
        // ===============================
        $membersWithTithe = Member::where('active', true)
            ->whereHas('donations', function ($q) use ($year, $month, $dizimoCategory) {
                $q->where('category_id', $dizimoCategory->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            })
            ->with(['donations' => function ($q) use ($year, $month, $dizimoCategory) {
                $q->where('category_id', $dizimoCategory->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            }])
            ->get();

        // ===============================
        // 8. Membros que NÃO PAGARAM
        // ===============================
        $membersWithoutTithe = Member::where('active', true)
            ->whereDoesntHave('donations', function ($q) use ($year, $month, $dizimoCategory) {
                $q->where('category_id', $dizimoCategory->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            })
            ->get();

        // ===============================
        // 9. Dados para gráfico mensal (ano)
        // ===============================
        $titheByMonth = Donation::selectRaw('MONTH(donation_date) as month, SUM(amount) as total')
            ->where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        // ===============================
        // 10. Retorno da view
        // ===============================
        return view('dashboard.dizimo_index', [
            'year'                  => $year,
            'month'                 => $month,

            'totalExpected'         => $totalExpected,
            'totalCollected'        => $totalCollected,
            'totalMissing'          => $totalMissing,

            'percentageCollected'   => $percentageCollected,
            'percentageMissing'     => $percentageMissing,

            'membersWithTithe'      => $membersWithTithe,
            'membersWithoutTithe'   => $membersWithoutTithe,

            'titheByMonth'          => $titheByMonth,

            'menu'                  => 'dashboard-dizimo',
        ]);
    }
}
