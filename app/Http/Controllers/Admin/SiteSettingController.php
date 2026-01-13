<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

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

        foreach ($request->except('_token', '_method') as $key => $value) {
            SiteSetting::updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Configurações atualizadas.');
    }
}