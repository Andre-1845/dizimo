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

        //  Salva campos normais (texto)
        foreach ($request->except(['_token', '_method', 'site_logo']) as $key => $value) {

            SiteSetting::updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );

            cache()->forget("setting_{$key}");
        }

        //  Remover logo
        if ($request->remove_logo) {

            $oldLogo = SiteSetting::where('key', 'site_logo')->value('value');

            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            SiteSetting::where('key', 'site_logo')->delete();

            cache()->forget('setting_site_logo');
        }

        //  Upload do logo

        if ($request->hasFile('site_logo')) {

            $oldLogo = SiteSetting::where('key', 'site_logo')->value('value');

            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('site_logo')->store('settings', 'public');

            SiteSetting::updateOrInsert(
                ['key' => 'site_logo'],
                ['value' => $path]
            );

            cache()->forget('setting_site_logo');
        }

        if ($request->hasFile('site_logo')) {

            $path = $request->file('site_logo')->store('settings', 'public');

            SiteSetting::updateOrInsert(
                ['key' => 'site_logo'],
                ['value' => $path]
            );

            cache()->forget('setting_site_logo');
        }

        return back()->with('success', 'Configurações atualizadas.');
    }
}