<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'description' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'values' => 'nullable|string',
            'slides' => 'nullable|array',
            'slides.*.title' => 'nullable|string|max:255',
            'slides.*.card_media_type' => 'nullable|in:image,video',
            'slides.*.popup_video_url' => 'nullable|string|max:2048',
            'slides.*.popup_video' => 'nullable|file|mimes:mp4,webm|max:51200',
            'slides.*.popup_video_path_existing' => 'nullable|string|max:500',
            'slides.*.popup_video_remove' => 'nullable|boolean',
            'slides.*.card_media' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,mp4,webm|max:20480',
            'slides.*.card_media_existing' => 'nullable|string|max:500',
        ]);

        $existingSlides = $about && is_array($about->about_feature_slides)
            ? $about->about_feature_slides
            : [];
        $slideRows = $request->input('slides', []);
        $slidesOut = [];
        foreach ($slideRows as $i => $row) {
            if (! is_array($row)) {
                continue;
            }
            $title = isset($row['title']) ? trim((string) $row['title']) : '';
            $cardMediaType = ($row['card_media_type'] ?? 'image') === 'video' ? 'video' : 'image';
            $popupUrl = isset($row['popup_video_url']) ? trim((string) $row['popup_video_url']) : '';
            $removePopupFile = ! empty($row['popup_video_remove']);

            $path = null;
            if ($request->hasFile("slides.$i.card_media")) {
                $stored = $request->file("slides.$i.card_media")->store('about_feature_slides', 'public');
                $path = $stored;
            } elseif (! empty($row['card_media_existing'])) {
                $path = $row['card_media_existing'];
            } elseif (isset($existingSlides[$i]['card_media'])) {
                $path = $existingSlides[$i]['card_media'];
            }

            if (empty($path) && $title === '' && $popupUrl === '') {
                continue;
            }

            if (empty($path)) {
                continue;
            }

            $prevPopupPath = $existingSlides[$i]['popup_video_path'] ?? null;
            $popupPath = null;

            if ($request->hasFile("slides.$i.popup_video")) {
                if (! empty($prevPopupPath)) {
                    Storage::disk('public')->delete($prevPopupPath);
                }
                $popupPath = $request->file("slides.$i.popup_video")->store('about_feature_popup_videos', 'public');
            } elseif ($removePopupFile) {
                if (! empty($prevPopupPath)) {
                    Storage::disk('public')->delete($prevPopupPath);
                }
                $popupPath = null;
            } elseif (! empty($row['popup_video_path_existing'])) {
                $popupPath = $row['popup_video_path_existing'];
            } elseif (! empty($prevPopupPath)) {
                $popupPath = $prevPopupPath;
            }

            $slideOut = [
                'title' => $title,
                'card_media_type' => $cardMediaType,
                'card_media' => $path,
                'popup_video_url' => $popupUrl,
            ];
            if (! empty($popupPath)) {
                $slideOut['popup_video_path'] = $popupPath;
            }

            $slidesOut[] = $slideOut;
        }

        $oldPaths = Collection::make($existingSlides)->pluck('card_media')->filter()->values();
        $newPaths = Collection::make($slidesOut)->pluck('card_media')->filter()->values();
        $oldPaths->diff($newPaths)->each(function (string $p) {
            Storage::disk('public')->delete($p);
        });

        $oldPopupPaths = Collection::make($existingSlides)->pluck('popup_video_path')->filter()->values();
        $newPopupPaths = Collection::make($slidesOut)->pluck('popup_video_path')->filter()->values();
        $oldPopupPaths->diff($newPopupPaths)->each(function (string $p) {
            Storage::disk('public')->delete($p);
        });

        $data['about_feature_slides'] = $slidesOut;
        unset($data['slides']);

        if ($request->hasFile('founder_image')) {
            if ($about && ! empty($about->founder_image)) {
                Storage::disk('public')->delete($about->founder_image);
            }
            $imagePath = $request->file('founder_image')->store('founder_images', 'public');
            $data['founder_image'] = str_replace('public/', '', $imagePath);
        }

        if ($request->hasFile('about_image')) {
            if ($about && ! empty($about->about_image)) {
                Storage::disk('public')->delete($about->about_image);
            }
            $aboutImagePath = $request->file('about_image')->store('about_images', 'public');
            $data['about_image'] = str_replace('public/', '', $aboutImagePath);
        }

        if ($about) {
            $about->update($data);
        } else {
            About::create($data);
        }

        return redirect()->back()->with('success', 'About information updated successfully.');
    }
}
