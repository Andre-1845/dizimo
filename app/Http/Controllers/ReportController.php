<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Apenas admin pode gerenciar relatórios
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Acesso não autorizado.');
        }

        $reports = Report::with('user')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('reports.index', [
            'reports' => $reports,
            'menu' => 'reports',
        ]);
    }

    public function create()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('reports.create', ['menu' => 'reports']);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'file' => 'required|file|mimes:pdf|max:5120', // 5MB
            'available_until' => 'nullable|date|after_or_equal:today',
            'is_active' => 'boolean',
        ]);

        $filePath = $request->file('file')->store('reports', 'public');

        Report::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'available_until' => $request->available_until,
            'is_active' => $request->boolean('is_active', true),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('reports.index')
            ->with('success', 'Relatório adicionado com sucesso.');
    }

    public function edit(Report $report)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('reports.edit', [
            'report' => $report,
            'menu' => 'reports',
        ]);
    }

    public function update(Request $request, Report $report)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'file' => 'nullable|file|mimes:pdf|max:5120',
            'available_until' => 'nullable|date|after_or_equal:today',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['title', 'description', 'available_until', 'is_active']);

        // Se enviou novo arquivo
        if ($request->hasFile('file')) {
            // Remove arquivo antigo
            Storage::disk('public')->delete($report->file_path);

            // Salva novo arquivo
            $data['file_path'] = $request->file('file')->store('reports', 'public');
        }

        $report->update($data);

        return redirect()->route('reports.index')
            ->with('success', 'Relatório atualizado com sucesso.');
    }

    public function destroy(Report $report)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Acesso não autorizado.');
        }

        // Remove arquivo
        Storage::disk('public')->delete($report->file_path);

        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Relatório removido com sucesso.');
    }

    public function toggleStatus(Report $report)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Acesso não autorizado.');
        }

        $report->update([
            'is_active' => !$report->is_active
        ]);

        return back()->with('success', 'Status do relatório alterado.');
    }
}
