<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteEvent;
use Illuminate\Http\Request;

class SiteEventController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', SiteEvent::class);

        $events = SiteEvent::orderBy('event_date')
            ->paginate(10);

        return view('admin.site.events.index', compact('events') + ['menu' => 'site']);
    }

    public function create()
    {
        $this->authorize('create', SiteEvent::class);

        return view('admin.site.events.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', SiteEvent::class);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'event_date'  => 'required|date',
            'time'        => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        SiteEvent::create($data);

        return redirect()
            ->route('admin.site.events.index')
            ->with('success', 'Evento criado com sucesso.');
    }

    public function edit(SiteEvent $event)
    {
        $this->authorize('update', $event);

        return view('admin.site.events.edit', compact('event'));
    }

    public function update(Request $request, SiteEvent $event)
    {
        $this->authorize('update', $event);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'event_date'  => 'required|date',
            'time'        => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $event->update($data);

        return redirect()
            ->route('admin.site.events.index')
            ->with('success', 'Evento atualizado com sucesso.');
    }

    public function destroy(SiteEvent $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()
            ->route('admin.site.events.index')
            ->with('success', 'Evento removido com sucesso.');
    }
}
