<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSection;
use Illuminate\Http\Request;

class SiteSectionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', SiteSection::class);

        $sections = SiteSection::orderBy('order')->get();

        return view('admin.site.sections.index', compact('sections') + ['menu' => 'site']);
    }

    public function edit(SiteSection $section)
    {
        $this->authorize('update', $section);

        return view('admin.site.sections.edit', compact('section'));
    }

    public function update(Request $request, SiteSection $section)
    {
        $this->authorize('update', $section);

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $section->update($data);
        $this->reindexOrder();

        return redirect()
            ->route('admin.site.sections.index')
            ->with('success', 'Seção atualizada com sucesso.');
    }

    private function reindexOrder(): void
    {
        SiteSection::orderBy('order')
            ->get()
            ->values()
            ->each(function ($section, $index) {
                $section->update([
                    'order' => $index + 1
                ]);
            });
    }
}
