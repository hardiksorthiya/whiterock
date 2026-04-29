<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            'light_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'favicon' => 'nullable|file|mimes:ico,png,jpg,jpeg,gif,webp|max:1024',
            'facebook_url' => 'nullable|string|max:2048',
            'instagram_url' => 'nullable|string|max:2048',
            'twitter_url' => 'nullable|string|max:2048',
            'whatsapp_url' => 'nullable|string|max:2048',
            'phone' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:10000',
            'contact_map_iframe' => 'nullable|string|max:65535',
            'contact_background_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'footer_text' => 'nullable|string|max:65535',
            'footer_copyright_text' => 'nullable|string|max:65535',
            'google_api_key' => 'nullable|string|max:255',
            'google_place_id' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'facebook_url',
            'instagram_url',
            'twitter_url',
            'whatsapp_url',
            'phone',
            'email',
            'contact_address',
            'contact_map_iframe',
            'footer_text',
            'footer_copyright_text',
            'google_api_key',
            'google_place_id',

        ]);

        if ($request->hasFile('logo')) {
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('light_logo')) {
            if ($setting->light_logo_path) {
                Storage::disk('public')->delete($setting->light_logo_path);
            }
            $data['light_logo_path'] = $request->file('light_logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon_path) {
                Storage::disk('public')->delete($setting->favicon_path);
            }
            $data['favicon_path'] = $request->file('favicon')->store('settings', 'public');
        }

        if ($request->hasFile('contact_background_image')) {
            if ($setting->contact_background_image_path) {
                Storage::disk('public')->delete($setting->contact_background_image_path);
            }

            $data['contact_background_image_path'] = $request
                ->file('contact_background_image')
                ->store('settings', 'public');
        }

        $oldPlaceId = (string) ($setting->google_place_id ?? '');
        $oldApiKey = (string) ($setting->google_api_key ?? '');
        $setting->update($data);
        $setting->refresh();
        Cache::forget('google_place_reviews_v2_'.md5($oldPlaceId.'|'.$oldApiKey));
        Cache::forget('google_place_reviews_v2_'.md5((string) ($setting->google_place_id ?? '').'|'.(string) ($setting->google_api_key ?? '')));

        return redirect()->route('backend.settings.edit')
            ->with('success', __('Settings saved successfully.'));
    }
}
