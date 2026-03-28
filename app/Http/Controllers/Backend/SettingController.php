<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::site();

        return view('backend.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::site();

        if ($request->input('email', null) === '') {
            $request->merge(['email' => null]);
        }

        $request->validate([
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'favicon' => 'nullable|file|mimes:ico,png,jpg,jpeg,gif,webp|max:1024',
            'facebook_url' => 'nullable|string|max:2048',
            'instagram_url' => 'nullable|string|max:2048',
            'twitter_url' => 'nullable|string|max:2048',
            'whatsapp_url' => 'nullable|string|max:2048',
            'phone' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'footer_text' => 'nullable|string|max:65535',
            'contact_locations' => 'nullable|array',
            'contact_locations.*.title' => 'nullable|string|max:255',
            'contact_locations.*.description' => 'nullable|string|max:10000',
            'contact_locations.*.map_iframe' => 'nullable|string|max:65535',
        ]);

        $data = $request->only([
            'facebook_url',
            'instagram_url',
            'twitter_url',
            'whatsapp_url',
            'phone',
            'email',
            'footer_text',
        ]);

        $locations = collect($request->input('contact_locations', []))
            ->map(function ($row) {
                return [
                    'title' => isset($row['title']) ? trim((string) $row['title']) : '',
                    'description' => isset($row['description']) ? trim((string) $row['description']) : '',
                    'map_iframe' => isset($row['map_iframe']) ? trim((string) $row['map_iframe']) : '',
                ];
            })
            ->filter(function ($row) {
                return $row['title'] !== '' || $row['description'] !== '' || $row['map_iframe'] !== '';
            })
            ->values()
            ->all();

        $data['contact_locations'] = $locations;

        if ($request->hasFile('logo')) {
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon_path) {
                Storage::disk('public')->delete($setting->favicon_path);
            }
            $data['favicon_path'] = $request->file('favicon')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()->route('backend.settings.edit')
            ->with('success', __('Settings saved successfully.'));
    }
}
