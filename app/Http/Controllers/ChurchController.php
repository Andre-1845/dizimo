<?php

namespace App\Http\Controllers;

use App\Models\Church;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChurchController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Church::class);

        $churches = Church::withCount([
            'members as members_total' => function ($query) {
                $query->withoutGlobalScope('church');
            }
        ])->orderBy('name')->paginate(10);

        return view('churches.index', compact('churches') + [
            'menu' => 'churches'
        ]);
    }

    public function create()
    {
        $this->authorize('create', Church::class);

        return view('churches.create', [
            'menu' => 'churches'
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Church::class);

        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'cnpj'    => 'nullable|string|max:20|unique:churches,cnpj',
            'address' => 'nullable|string|max:255',
            'logo'    => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')
                ->store('churches/logos', 'public');
        }

        Church::create($data);

        return redirect()
            ->route('churches.index')
            ->with('success', 'Igreja cadastrada com sucesso.');
    }

    public function edit(Church $church)
    {
        $this->authorize('update', $church);

        return view('churches.edit', compact('church') + [
            'menu' => 'churches'
        ]);
    }

    public function update(Request $request, Church $church)
    {
        $this->authorize('update', $church);

        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'cnpj'    => 'nullable|string|max:20|unique:churches,cnpj,' . $church->id,
            'address' => 'nullable|string|max:255',
            'logo'    => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {

            if ($church->logo) {
                Storage::disk('public')->delete($church->logo);
            }

            $data['logo'] = $request->file('logo')
                ->store('churches/logos', 'public');
        }

        $church->update($data);

        return redirect()
            ->route('churches.index')
            ->with('success', 'Igreja atualizada com sucesso.');
    }

    public function show(Church $church)
    {
        $this->authorize('view', $church);

        $church->loadCount([
            'members' => fn($q) => $q->withoutGlobalScope('church'),
            'donations' => fn($q) => $q->withoutGlobalScope('church'),
            'expenses' => fn($q) => $q->withoutGlobalScope('church'),
        ]);

        return view('churches.show', compact('church') + [
            'menu' => 'churches'
        ]);
    }

    public function destroy(Church $church)
    {
        $this->authorize('delete', $church);

        if ($church->members()->exists()) {
            return back()->with(
                'error',
                'Não é possível excluir igreja com membros vinculados.'
            );
        }

        if ($church->logo) {
            Storage::disk('public')->delete($church->logo);
        }

        $church->delete();

        return redirect()
            ->route('churches.index')
            ->with('success', 'Igreja excluída com sucesso.');
    }
}