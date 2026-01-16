<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSection;
use App\Models\SiteImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteImageController extends Controller
{
    public function index(SiteSection $section)
    {
        $this->authorize('viewAny', SiteImage::class);

        $images = SiteImage::where('section_key', $section->key)
            ->orderBy('order')
            ->get();

        return view('admin.site.images.index', compact('section', 'images') + ['menu' => 'site']);
    }

    public function store(Request $request, SiteSection $section)
    {
        $this->authorize('create', SiteImage::class);
        $data = $request->validate([
            'image'   => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('site', 'public');

        SiteImage::create([
            'section_key' => $section->key,
            'image_path'  => $path,
            'caption'     => $data['caption'] ?? null,
            'order'       => SiteImage::where('section_key', $section->key)->count(),
        ]);

        return back()->with('success', 'Imagem adicionada com sucesso.');
    }

    public function destroy(SiteImage $image)
    {
        $this->authorize('delete', $image);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Imagem removida.');
    }
}