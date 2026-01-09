<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSection;
use Illuminate\Http\Request;

class SiteSectionController extends Controller
{
    public function index()
    {
        $sections = SiteSection::orderBy('order')->get();

        return view('admin.site.sections.index', compact('sections') + ['menu' => 'site']);
    }

    public function edit(SiteSection $section)
    {
        return view('admin.site.sections.edit', compact('section'));
    }

    public function update(Request $request, SiteSection $section)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $section->update($data);

        return redirect()
            ->route('admin.site.sections.index')
            ->with('success', 'Seção atualizada com sucesso.');
    }
}
