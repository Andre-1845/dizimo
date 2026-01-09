<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = \App\Models\SiteSetting::pluck('value', 'key');
        return view('admin.site.settings.edit', compact('settings') + ['menu' => 'site']);
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            \App\Models\SiteSetting::updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Configurações atualizadas.');
    }
}
