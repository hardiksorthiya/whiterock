<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Slider;

class FrontendController extends Controller
{
    public function home()
    {
        $sliders = Slider::where('is_active', 1)->get();
        $setting = Setting::site();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();

        return view('frontend.pages.home', compact('sliders', 'setting', 'latestGalleryImages', 'footerPages'));
    }

    public function about()
    {
        $setting = Setting::site();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();

        return view('frontend.pages.about', compact('setting', 'latestGalleryImages', 'footerPages'));
    }

    public function contact()
    {
        $setting = Setting::site();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();

        return view('frontend.pages.contact', compact('setting', 'latestGalleryImages', 'footerPages'));
    }

    public function gallery()
    {
        $setting = Setting::site();
        $categories = GalleryCategory::with('images')->get();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();

        return view('frontend.pages.gallery', compact('setting', 'categories', 'latestGalleryImages', 'footerPages'));
    }

    public function page(string $slug)
    {
        $setting = Setting::site();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();
        $page = Page::query()->where('is_active', true)->where('slug', $slug)->firstOrFail();

        return view('frontend.pages.dynamic', compact('setting', 'latestGalleryImages', 'footerPages', 'page'));
    }
}
