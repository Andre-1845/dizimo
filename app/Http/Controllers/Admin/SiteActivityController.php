<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteActivity;
use Illuminate\Http\Request;

class SiteActivityController extends Controller
{
    public function index()
    {
        $activities = SiteActivity::orderBy('order')->get();
        return view('admin.site.site-activities.index', compact('activities'));
    }

    public function create()
    {
        $data['order'] = SiteActivity::max('order') + 1;
        return view('admin.site.site-activities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'day' => 'required|string|max:100',
            'time' => 'required|string|max:100',
            'email' => 'nullable|email',
            'schedule_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        // Ativo / inativo
        $data['active'] = $request->has('active');

        // 🔥 ORDEM AUTOMÁTICA
        if (($data['order'] == 0) || (!isset($data['order']))) {
            $data['order'] = SiteActivity::max('order') + 1;
        } else {
            $this->normalizeOrder($data['order']);
        }

        SiteActivity::create($data);
        // Reorganiza a ordem após exclusão
        $this->reindexOrder();

        return redirect()
            ->route('admin.site.site-activities.index')
            ->with('success', 'Atividade cadastrada com sucesso.');
    }

    public function edit(SiteActivity $siteActivity)
    {
        return view('admin.site.site-activities.edit', compact('siteActivity'));
    }

    public function update(Request $request, SiteActivity $siteActivity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'day'  => 'required|string|max:100',
            'time' => 'required|string|max:100',
            'email' => 'nullable|email',
            'schedule_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);


        if ($request['order'] != $siteActivity->order) {
            $this->normalizeOrder($request['order'], $siteActivity->id);
        }

        $siteActivity->update($request->all());
        // Reorganiza a ordem após exclusão
        $this->reindexOrder();

        return redirect()
            ->route('admin.site.site-activities.index')
            ->with('success', 'Atividade atualizada com sucesso.');
    }

    public function destroy(SiteActivity $siteActivity)
    {
        $siteActivity->delete();
        // Reorganiza a ordem após exclusão
        $this->reindexOrder();

        return redirect()
            ->route('admin.site.site-activities.index')
            ->with('success', 'Atividade removida.');
    }


    private function normalizeOrder(int $order, ?int $ignoreId = null): void
    {
        $query = SiteActivity::where('order', '>=', $order);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $query->increment('order');
    }

    private function reindexOrder(): void
    {
        SiteActivity::orderBy('order')
            ->get()
            ->values()
            ->each(function ($activity, $index) {
                $activity->update([
                    'order' => $index + 1
                ]);
            });
    }
}
