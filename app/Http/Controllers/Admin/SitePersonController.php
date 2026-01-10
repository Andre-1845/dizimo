<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitePerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SitePersonController extends Controller
{
    /**
     * Listagem
     */
    public function index()
    {
        $people = SitePerson::orderBy('order')->get();

        return view('admin.site.people.index', compact('people'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        return view('admin.site.people.create');
    }

    /**
     * Salvar novo registro
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'role'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
            'photo_cropped' => 'nullable|string',
        ]);

        // Ativo / Inativo
        $data['is_active'] = $request->has('is_active');

        // Ordem automática
        if (!isset($data['order'])) {
            $data['order'] = SitePerson::max('order') + 1;
        }

        // Salvar imagem recortada (Base64)
        if (!empty($data['photo_cropped'])) {
            $data['photo_path'] = $this->storeCroppedImage($data['photo_cropped']);
        }

        unset($data['photo_cropped']);

        SitePerson::create($data);

        return redirect()
            ->route('admin.site.people.index')
            ->with('success', 'Pessoa cadastrada com sucesso.');
    }

    /**
     * Formulário de edição
     */
    public function edit(SitePerson $person)
    {
        return view('admin.site.people.edit', compact('person'));
    }

    /**
     * Atualizar registro
     */
    public function update(Request $request, SitePerson $person)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'role'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
            'photo_cropped' => 'nullable|string',
        ]);

        $data['is_active'] = $request->has('is_active');

        // Atualizar imagem (se houver nova)
        if (!empty($data['photo_cropped'])) {
            // Remove imagem antiga
            if ($person->photo_path && Storage::disk('public')->exists($person->photo_path)) {
                Storage::disk('public')->delete($person->photo_path);
            }

            $data['photo_path'] = $this->storeCroppedImage($data['photo_cropped']);
        }

        unset($data['photo_cropped']);

        $person->update($data);

        return redirect()
            ->route('admin.site.people.index')
            ->with('success', 'Pessoa atualizada com sucesso.');
    }

    /**
     * Remover registro
     */
    public function destroy(SitePerson $person)
    {
        if ($person->photo_path && Storage::disk('public')->exists($person->photo_path)) {
            Storage::disk('public')->delete($person->photo_path);
        }

        $person->delete();

        // Reorganiza a ordem após exclusão
        $this->reindexOrder();

        return redirect()
            ->route('admin.site.people.index')
            ->with('success', 'Pessoa removida com sucesso.');
    }

    /**
     * 🔧 Salva imagem recortada (Base64)
     */
    private function storeCroppedImage(string $base64): string
    {
        $image = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
        $image = base64_decode($image);

        $filename = 'people/' . uniqid() . '.jpg';

        Storage::disk('public')->put($filename, $image);

        return $filename;
    }

    /**
     * 🔄 Reorganiza a ordem (1,2,3...)
     */
    private function reindexOrder(): void
    {
        SitePerson::orderBy('order')
            ->get()
            ->values()
            ->each(function ($person, $index) {
                $person->update([
                    'order' => $index + 1
                ]);
            });
    }
}
