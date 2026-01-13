<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteNotice;
use Illuminate\Http\Request;

class SiteNoticeController extends Controller
{
    /**
     * Lista de avisos
     */
    public function index()
    {
        $this->authorize('view', SiteNotice::class);

        $notices = SiteNotice::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.site.notices.index', compact('notices'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        $this->authorize('create', SiteNotice::class);

        return view('admin.site.notices.create');
    }

    /**
     * Salvar novo aviso
     */
    public function store(Request $request)
    {
        $this->authorize('create', SiteNotice::class);

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'starts_at'  => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active'  => 'sometimes|boolean',
        ]);

        SiteNotice::create($validated);

        return redirect()
            ->route('admin.site.notices.index')
            ->with('success', 'Aviso criado com sucesso.');
    }

    /**
     * Formulário de edição
     */
    public function edit(SiteNotice $notice)
    {
        $this->authorize('update', $notice);

        return view('admin.site.notices.edit', compact('notice'));
    }

    /**
     * Atualizar aviso
     */
    public function update(Request $request, SiteNotice $notice)
    {
        $this->authorize('update', $notice);

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'starts_at'  => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active'  => 'sometimes|boolean',
        ]);

        $notice->update($validated);

        return redirect()
            ->route('admin.site.notices.index')
            ->with('success', 'Aviso atualizado com sucesso.');
    }

    /**
     * Excluir aviso
     */
    public function destroy(SiteNotice $notice)
    {
        $this->authorize('delete', $notice);

        $notice->delete();

        return redirect()
            ->route('admin.site.notices.index')
            ->with('success', 'Aviso excluído com sucesso.');
    }
}