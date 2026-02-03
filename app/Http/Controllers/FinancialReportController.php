<?php

namespace App\Http\Controllers;

use App\Models\FinancialReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FinancialReportController extends Controller
{
    /**
     * Lista relatórios (ADMIN)
     */
    public function index()
    {
        $this->authorize('viewAny', FinancialReport::class);

        $reports = FinancialReport::orderByDesc('created_at')->paginate(15);

        return view('reports.index', compact('reports'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        $this->authorize('create', FinancialReport::class);

        return view('reports.create');
    }

    /**
     * Salva relatório
     */
    public function store(Request $request)
    {
        $this->authorize('create', FinancialReport::class);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'file'            => 'required|file|mimes:pdf|max:10240', // 10MB
            'type'            => 'required|string|max:50',
            'reference_month' => 'nullable|date',
            'published_at'    => 'nullable|date',
            'valid_until'     => 'nullable|date|after_or_equal:published_at',
            'is_published'    => 'nullable|boolean',
        ]);

        // Upload do PDF
        $filePath = $request->file('file')->store('financial-reports', 'public');

        FinancialReport::create([
            'title'           => $validated['title'],
            'description'     => $validated['description'] ?? null,
            'file_path'       => $filePath,
            'type'            => $validated['type'],
            'reference_month' => $validated['reference_month'] ?? null,
            'published_at'    => $request->boolean('is_published')
                ? ($validated['published_at'] ?? now())
                : null,
            'valid_until'     => $validated['valid_until'] ?? null,
            'is_published'    => $request->boolean('is_published'),
            'published_by'    => $request->boolean('is_published')
                ? Auth::id()
                : null,
        ]);

        return redirect()
            ->route('reports.index')
            ->with('success', 'Relatório cadastrado com sucesso.');
    }

    /**
     * Formulário de edição
     */
    public function edit(FinancialReport $report)
    {
        $this->authorize('update', $report);

        return view('reports.edit', compact('report'));
    }

    /**
     * Atualiza relatório
     */
    public function update(Request $request, FinancialReport $report)
    {
        $this->authorize('update', $report);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'file'            => 'nullable|file|mimes:pdf|max:10240',
            'type'            => 'required|string|max:50',
            'reference_month' => 'nullable|date',
            'published_at'    => 'nullable|date',
            'valid_until'     => 'nullable|date|after_or_equal:published_at',
            'is_published'    => 'nullable|boolean',
        ]);

        // Se trocar o PDF
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($report->file_path);

            $report->file_path = $request->file('file')
                ->store('financial-reports', 'public');
        }

        // Atualiza dados
        $report->update([
            'title'           => $validated['title'],
            'description'     => $validated['description'] ?? null,
            'type'            => $validated['type'],
            'reference_month' => $validated['reference_month'] ?? null,
            'valid_until'     => $validated['valid_until'] ?? null,
            'is_published'    => $request->boolean('is_published'),
            'published_at'    => $request->boolean('is_published')
                ? ($validated['published_at'] ?? now())
                : null,
            'published_by'    => $request->boolean('is_published')
                ? Auth::id()
                : null,
        ]);

        return redirect()
            ->route('reports.index')
            ->with('success', 'Relatório atualizado com sucesso.');
    }

    /**
     * Remove relatório
     */
    public function destroy(FinancialReport $report)
    {
        $this->authorize('delete', $report);

        Storage::disk('public')->delete($report->file_path);
        $report->delete();

        return redirect()
            ->route('reports.index')
            ->with('success', 'Relatório removido.');
    }
}
