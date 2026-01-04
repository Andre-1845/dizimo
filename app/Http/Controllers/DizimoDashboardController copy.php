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
        // *****  Paginacao  ********
        $perPage = (int) $request->get('per_page', 10);

        $allowedPerPage = [10, 20, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }
        /* =====================
     |  CONTADORES
     ===================== */

        $membersCount = Member::count();
        $membersActiveCount = Member::active()->count();

        $membersInactiveCount = ($membersCount - $membersActiveCount);


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
        // 4. Total ARRECADADO (mes ou ano)
        // ===============================
        $totalCollected = Donation::where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->sum('amount');

        $totalCollectedYear = Donation::where('category_id', $dizimoCategory->id)
            ->whereYear('donation_date', $year)
            ->sum('amount');

        // $query = Donation::where('category_id', $dizimoCategory->id)
        //     ->whereYear('donation_date', $year);

        // if ($month) {
        //     $query->whereMonth('donation_date', $month);
        // }

        // $totalCollected = $query->sum('amount');


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
            ->paginate($perPage, ['*'], 'paid_page')
            ->withQueryString();

        // ===============================
        // 8. Membros que NÃO DOARAM
        // ===============================
        $membersWithoutTithe = Member::where('active', true)
            ->whereDoesntHave('donations', function ($q) use ($year, $month, $dizimoCategory) {
                $q->where('category_id', $dizimoCategory->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            })
            ->paginate($perPage, ['*'], 'unpaid_page')
            ->withQueryString();

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

            'membersCount'   => $membersCount,
            'membersActiveCount' => $membersActiveCount,
            'membersInactiveCount' => $membersInactiveCount,

            'totalExpected'         => $totalExpected,
            'totalCollected'        => $totalCollected,
            'totalMissing'          => $totalMissing,
            'totalCollectedYear'    => $totalCollectedYear,

            'percentageCollected'   => $percentageCollected,
            'percentageMissing'     => $percentageMissing,

            'membersWithTithe'      => $membersWithTithe,
            'membersWithoutTithe'   => $membersWithoutTithe,

            'titheByMonth'          => $titheByMonth,

            'menu'                  => 'dashboard-dizimo',
        ]);
    }
}
