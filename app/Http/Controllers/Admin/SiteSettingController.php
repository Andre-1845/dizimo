<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $this->authorize('update', SiteSetting::class);

        $settings = SiteSetting::pluck('value', 'key');
        return view('admin.site.settings.edit', compact('settings') + ['menu' => 'site']);
    }

    public function update(Request $request)
    {
        $this->authorize('update', SiteSetting::class);

        $request->validate([
            'app_name' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|max:2048',
        ]);

        // Trata checkbox
        SiteSetting::set(
            'use_default_email_templates',
            $request->has('use_default_email_templates') ? 1 : 0
        );

        // Salva campos de texto
        foreach ($request->except(['_token', '_method', 'site_logo', 'remove_logo', 'use_default_email_templates']) as $key => $value) {
            SiteSetting::set($key, $value);
        }

        // Remover logo
        if ($request->has('remove_logo')) {

            $oldLogo = SiteSetting::get('site_logo');

            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            SiteSetting::deleteKey('site_logo'); // método novo no model
        }

        // Upload nova logo
        if ($request->hasFile('site_logo')) {

            $oldLogo = SiteSetting::get('site_logo');

            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('site_logo')->store('settings', 'public');

            SiteSetting::set('site_logo', $path);
        }

        return back()->with('success', 'Configurações atualizadas.');
    }
}
