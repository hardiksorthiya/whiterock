<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function show(): View
    {
        $setting = Setting::site();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();

        /** @var int|null $careerPageGalleryCategoryId Backend: gallery category primary key (`gallery_categories.id`). Same pattern as gypsum page slider. */
        $careerPageGalleryCategoryId =5;

        $careerGallerySliderCategory = $careerPageGalleryCategoryId
            ? GalleryCategory::query()->with('images')->find((int) $careerPageGalleryCategoryId)
            : null;

        return view('frontend.pages.career', compact(
            'setting',
            'latestGalleryImages',
            'footerPages',
            'careerGallerySliderCategory'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:40',
            'years_experience' => 'required|string|max:80',
            'education' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'hire_why' => 'required|string|max:8000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $cvPath = $request->file('cv')->store('career-cvs', 'public');

        CareerApplication::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'years_experience' => $validated['years_experience'],
            'education' => $validated['education'],
            'position' => $validated['position'],
            'hire_why' => $validated['hire_why'],
            'cv_path' => $cvPath,
        ]);

        return redirect()->route('career')->with('success', 'Thank you — your application has been submitted. Our team will review it shortly.');
    }
}
