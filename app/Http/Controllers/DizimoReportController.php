<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Donation;
use App\Models\Category;
use App\Models\Church;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;


class DizimoReportController extends Controller
{
    private function currentChurch()
    {
        return Church::find(session('view_church_id'));
    }

    private function filtros(Request $request)
    {
        return [
            'year'  => (int) $request->get('year', now()->year),
            'month' => (int) $request->get('month', now()->month),
            'perPage' => (int) $request->get('per_page', 20),
        ];
    }

    private function dizimoCategory()
    {
        return Category::where('name', 'Dízimo')->firstOrFail();
    }

    // =========================================
    // 1. MEMBROS QUE PAGARAM
    // =========================================
    public function paid(Request $request)
    {
        $filters = $this->filtros($request);
        $category = $this->dizimoCategory();

        $members = Member::whereHas('donations', function ($q) use ($filters, $category) {
            $q->where('category_id', $category->id)
                ->whereYear('donation_date', $filters['year'])
                ->whereMonth('donation_date', $filters['month']);
        })
            ->with(['donations' => function ($q) use ($filters, $category) {
                $q->where('category_id', $category->id)
                    ->whereYear('donation_date', $filters['year'])
                    ->whereMonth('donation_date', $filters['month'])
                    ->orderBy('donation_date', 'desc');
            }])
            ->orderBy('name')
            ->paginate($filters['perPage'])
            ->withQueryString();

        $membersAll = Member::whereHas('donations', function ($q) use ($filters, $category) {
            $q->where('category_id', $category->id)
                ->whereYear('donation_date', $filters['year'])
                ->whereMonth('donation_date', $filters['month']);
        })
            ->with(['donations' => function ($q) use ($filters, $category) {
                $q->where('category_id', $category->id)
                    ->whereYear('donation_date', $filters['year'])
                    ->whereMonth('donation_date', $filters['month']);
            }])
            ->get();

        $totalDoado = $membersAll
            ->sum(fn($member) => $member->donations->sum('amount'));

        $totalPrevisto = $membersAll
            ->sum('monthly_tithe');



        return view('dashboard.reports.dizimo_paid', [
            'menu' => 'dashboard-dizimo',
            'members' => $members,
            'filters' => $filters,
            'totalDoado' =>  $totalDoado,
            'totalPrevisto' => $totalPrevisto,
            'church' => $this->currentChurch(),
        ]);
    }

    public function exportPaidCsv(Request $request): StreamedResponse
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $category = Category::where('name', 'Dízimo')->firstOrFail();

        $members = Member::whereHas('donations', function ($q) use ($category, $year, $month) {
            $q->where('category_id', $category->id)
                ->whereYear('donation_date', $year)
                ->whereMonth('donation_date', $month);
        })
            ->with(['donations' => function ($q) use ($category, $year, $month) {
                $q->where('category_id', $category->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            }])
            ->orderBy('name')
            ->get();

        $filename = "dizimo_pagaram_{$month}_{$year}.csv";

        return response()->stream(function () use ($members) {

            $handle = fopen('php://output', 'w');

            // BOM UTF-8 (evita problemas com acentos)
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Cabeçalho
            fputcsv($handle, ['Membro', 'Datas das Doações', 'Valor'], ';');

            foreach ($members as $member) {
                // fputcsv($handle, [
                //     $member->name,
                //     number_format($member->donations->sum('amount'), 2, '.', '')
                // ]);


                $dates = $member->donations
                    ->pluck('donation_date')
                    ->map(fn($d) => $d->format('d/m/Y'))
                    ->join(' | ');

                fputcsv($handle, [
                    $member->name,
                    $dates,
                    number_format($member->donations->sum('amount'), 2, '.', '')
                ], ';');
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function exportPaidPdf(Request $request)
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $category = Category::where('name', 'Dízimo')->firstOrFail();

        $members = Member::whereHas('donations', function ($q) use ($category, $year, $month) {
            $q->where('category_id', $category->id)
                ->whereYear('donation_date', $year)
                ->whereMonth('donation_date', $month);
        })
            ->with(['donations' => function ($q) use ($category, $year, $month) {
                $q->where('category_id', $category->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            }])
            ->orderBy('name')
            ->get();

        $church = $this->currentChurch();

        $pdf = Pdf::loadView('pdf.dizimo_paid', compact(
            'members',
            'year',
            'month',
            'church',
        ))->setPaper('a4', 'portrait')
            ->setOptions([
                'enable_php' => true,
            ]);

        return $pdf->download("dizimo_pagaram_{$month}_{$year}.pdf");
    }


    // =========================================
    // 2. MEMBROS PENDENTES
    // =========================================
    public function pending(Request $request)
    {
        $filters = $this->filtros($request);
        $category = $this->dizimoCategory();

        $members = Member::where('active', true)
            ->whereDoesntHave('donations', function ($q) use ($filters, $category) {
                $q->where('category_id', $category->id)
                    ->whereYear('donation_date', $filters['year'])
                    ->whereMonth('donation_date', $filters['month']);
            })
            ->orderBy('name')
            ->paginate($filters['perPage'])
            ->withQueryString();

        return view('dashboard.reports.dizimo_pending', [
            'menu' => 'dashboard-dizimo',
            'members' => $members,
            'filters' => $filters,
            'church' => $this->currentChurch(),
        ]);
    }

    public function exportPendingCsv(Request $request): StreamedResponse
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $category = Category::where('name', 'Dízimo')->firstOrFail();

        $members = Member::where('active', true)
            ->whereDoesntHave('donations', function ($q) use ($category, $year, $month) {
                $q->where('category_id', $category->id)
                    ->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            })
            ->orderBy('name')
            ->get();

        $filename = "dizimo_pendentes_{$month}_{$year}.csv";

        return response()->stream(function () use ($members) {

            $handle = fopen('php://output', 'w');

            // BOM UTF-8 (evita problemas com acentos)
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['Membro', 'Valor Previsto'], ';');

            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->name,
                    number_format($member->monthly_tithe, 2, '.', '')
                ], ';');
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function exportPendingPdf(Request $request)
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $members = Member::where('active', true)
            ->whereDoesntHave('donations', function ($q) use ($year, $month) {
                $q->whereYear('donation_date', $year)
                    ->whereMonth('donation_date', $month);
            })
            ->orderBy('name')
            ->get();

        $church = $this->currentChurch();

        $pdf = Pdf::loadView('pdf.dizimo_pending', compact(
            'members',
            'year',
            'month',
            'church',
        ))->setPaper('a4', 'portrait');

        return $pdf->download("dizimo_pendentes_{$month}_{$year}.pdf");
    }



    // =========================================
    // 3. DOAÇÕES ANÔNIMAS / ADMINISTRAÇÃO
    // =========================================
    public function anonymous(Request $request)
    {
        $filters = $this->filtros($request);
        $category = $this->dizimoCategory();

        $donations = Donation::whereNull('member_id')
            ->where('category_id', $category->id)
            ->whereYear('donation_date', $filters['year'])
            ->whereMonth('donation_date', $filters['month'])
            ->orderBy('donation_date', 'desc')
            ->paginate($filters['perPage'])
            ->withQueryString();

        return view('dashboard.reports.dizimo_anonymous', [
            'menu' => 'dashboard-dizimo',
            'donations' => $donations,
            'filters' => $filters,
            'church' => $this->currentChurch(),
        ]);
    }

    public function exportAnonymousCsv(Request $request): StreamedResponse
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $category = Category::where('name', 'Dízimo')->firstOrFail();

        $donations = Donation::whereNull('member_id')
            ->where('category_id', $category->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->orderBy('donation_date')
            ->get();

        $filename = "dizimo_anonimos_{$month}_{$year}.csv";

        return response()->stream(function () use ($donations) {

            $handle = fopen('php://output', 'w');

            // BOM UTF-8 (evita problemas com acentos)
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['Origem', 'Data', 'Valor'], ';');

            foreach ($donations as $donation) {
                fputcsv($handle, [
                    $donation->donor_name ?? 'Administração',
                    $donation->donation_date->format('d/m/Y'),
                    number_format($donation->amount, 2, '.', '')
                ], ';');
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }


    public function exportAnonymousPdf(Request $request)
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $category = Category::where('name', 'Dízimo')->firstOrFail();

        $donations = Donation::whereNull('member_id')
            ->where('category_id', $category->id)
            ->whereYear('donation_date', $year)
            ->whereMonth('donation_date', $month)
            ->orderBy('donation_date')
            ->get();

        $church = $this->currentChurch();

        $pdf = Pdf::loadView('pdf.dizimo_anonymous', compact(
            'donations',
            'year',
            'month',
            'church',
        ))->setPaper('a4', 'portrait');

        return $pdf->download("dizimo_anonimos_{$month}_{$year}.pdf");
    }







    // ************* fim ***************
}