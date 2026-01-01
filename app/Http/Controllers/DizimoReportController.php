<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Donation;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DizimoReportController extends Controller
{
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

        $members = Member::where('active', true)
            ->whereHas('donations', function ($q) use ($filters, $category) {
                $q->where('category_id', $category->id)
                    ->whereYear('donation_date', $filters['year'])
                    ->whereMonth('donation_date', $filters['month']);
            })
            ->with(['donations' => function ($q) use ($filters, $category) {
                $q->where('category_id', $category->id)
                    ->whereYear('donation_date', $filters['year'])
                    ->whereMonth('donation_date', $filters['month']);
            }])
            ->orderBy('name')
            ->paginate($filters['perPage'])
            ->withQueryString();

        return view('dashboard.reports.dizimo_paid', compact(
            'members',
            'filters'
        ));
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

        return view('dashboard.reports.dizimo_pending', compact(
            'members',
            'filters'
        ));
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

        return view('dashboard.reports.dizimo_anonymous', compact(
            'donations',
            'filters'
        ));
    }

    public function exportPaidCsv(Request $request): StreamedResponse
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $category = Category::where('name', 'Dízimo')->firstOrFail();

        $members = Member::where('active', true)
            ->whereHas('donations', function ($q) use ($category, $year, $month) {
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

            // Cabeçalho
            fputcsv($handle, ['Membro', 'Valor']);

            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->name,
                    number_format($member->donations->sum('amount'), 2, '.', '')
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
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

            fputcsv($handle, ['Membro', 'Valor Previsto']);

            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->name,
                    number_format($member->monthly_tithe, 2, '.', '')
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
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

            fputcsv($handle, ['Origem', 'Data', 'Valor']);

            foreach ($donations as $donation) {
                fputcsv($handle, [
                    $donation->donor_name ?? 'Administração',
                    $donation->donation_date->format('d/m/Y'),
                    number_format($donation->amount, 2, '.', '')
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }






    // ************* fim ***************
}
