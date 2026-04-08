<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        $about = About::first();
        return view('backend.about.edit', compact('about'));
    }
    public function update(Request $request)
    {
        $about = About::first();
        $data = $request->validate([
            'founder_name' => 'nullable|string|max:255',
            'founder_designation' => 'nullable|string|max:255',
            'founder_description' => 'nullable|string',
            'founder_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'values' => 'nullable|string',
        ]);

        if ($request->hasFile('founder_image')) {
            if ($about && ! empty($about->founder_image)) {
                Storage::disk('public')->delete($about->founder_image);
            }
            $imagePath = $request->file('founder_image')->store('founder_images', 'public');
            $data['founder_image'] = str_replace('public/', '', $imagePath);
        }

        if ($about) {
            $about->update($data);
        } else {
            About::create($data);
        }

        return redirect()->back()->with('success', 'About information updated successfully.');
    }
}
