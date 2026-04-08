<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    public function home()
    {
        $sliders = Slider::where('is_active', 1)->get();
        $setting = Setting::site();
        $services = Service::where('is_active', 1)->latest()->get();
        $galleryCategories = GalleryCategory::with('images')->get();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $products = Product::query()->where('is_active', true)->latest()->take(8)->get();
        $productCategories = ProductCategory::query()->where('is_active', true)->latest()->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();
        $googleReviewsData = $this->fetchGooglePlaceReviews($setting);

        return view('frontend.pages.home', compact('sliders', 'setting', 'services', 'latestGalleryImages', 'galleryCategories', 'footerPages', 'products', 'productCategories', 'googleReviewsData'));
    }

    

    public function about()
    {
        $setting = Setting::site();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();
        $about = About::first();

        return view('frontend.pages.about', compact('setting', 'latestGalleryImages', 'footerPages', 'about'));
    }

    public function contact()
    {
        $setting = Setting::site();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();

        return view('frontend.pages.contact', compact('setting', 'latestGalleryImages', 'footerPages'));
    }

    public function products()
    {
        $setting = Setting::site();
        $products = Product::query()->where('is_active', true)->latest()->get();
        $productCategories = ProductCategory::query()->where('is_active', true)->latest()->get();
        $latestGalleryImages = GalleryImage::query()->latest()->take(6)->get();
        $footerPages = Page::query()->where('is_active', true)->latest()->get();

        return view('frontend.pages.products', compact('setting', 'products', 'productCategories', 'latestGalleryImages', 'footerPages'));
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

    /**
     * Debug: JSON for the same cached payload as the home page (check status / error_message if reviews are empty).
     */
    public function googleReviews()
    {
        $setting = Setting::site();

        // Bust cache: /google-reviews?refresh=1 (use after fixing API key or Place ID)
        if (request()->query('refresh') === '1') {
            $apiKey = trim((string) ($setting->google_api_key ?? ''));
            $placeId = trim((string) ($setting->google_place_id ?? ''));
            if ($apiKey !== '' && $placeId !== '') {
                Cache::forget('google_place_reviews_v2_'.md5($placeId.'|'.$apiKey));
            }
        }

        $data = $this->fetchGooglePlaceReviews($setting);

        return response()->json($data);
    }

    /**
     * Cached Google Place Details (reviews). Enable "Places API" in Google Cloud and billing if required.
     *
     * @return array{reviews: array<int, array<string, mixed>>, place_name: ?string, overall_rating: ?float, user_ratings_total: ?int, api_status: ?string, api_error_message: ?string}
     */
    protected function fetchGooglePlaceReviews(Setting $setting): array
    {
        $empty = [
            'reviews' => [],
            'place_name' => null,
            'overall_rating' => null,
            'user_ratings_total' => null,
            'api_status' => null,
            'api_error_message' => null,
        ];

        $apiKey = trim((string) ($setting->google_api_key ?? ''));
        $placeId = trim((string) ($setting->google_place_id ?? ''));

        if ($apiKey === '' || $placeId === '') {
            return $empty;
        }

        $cacheKey = 'google_place_reviews_v2_'.md5($placeId.'|'.$apiKey);

        // Only successful OK responses are cached. Failed/empty attempts were previously cached for 1h and hid reviews after fixing keys.
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::timeout(20)
                ->acceptJson()
                ->get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => $placeId,
                    'fields' => 'name,rating,reviews,user_ratings_total',
                    'key' => $apiKey,
                ]);
        } catch (\Throwable $e) {
            Log::warning('Google Place Details HTTP exception', [
                'message' => $e->getMessage(),
            ]);

            return array_merge($empty, [
                'api_status' => 'HTTP_EXCEPTION',
                'api_error_message' => $e->getMessage(),
            ]);
        }

        if (! $response->successful()) {
            Log::warning('Google Place Details bad HTTP status', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return array_merge($empty, [
                'api_status' => 'HTTP_'.$response->status(),
                'api_error_message' => 'Bad response from Google',
            ]);
        }

        $json = $response->json();
        if (! is_array($json)) {
            Log::warning('Google Place Details invalid JSON', ['body' => $response->body()]);

            return array_merge($empty, [
                'api_status' => 'INVALID_JSON',
                'api_error_message' => 'Could not parse Google response',
            ]);
        }

        $status = $json['status'] ?? null;
        $errorMessage = $json['error_message'] ?? null;

        if ($status !== 'OK') {
            // Do not cache — key restrictions / billing often fixed without waiting 1 hour.
            Log::warning('Google Place Details failed', [
                'status' => $status,
                'error_message' => $errorMessage,
            ]);

            return array_merge($empty, [
                'api_status' => is_string($status) ? $status : null,
                'api_error_message' => is_string($errorMessage) ? $errorMessage : null,
            ]);
        }

        $result = $json['result'] ?? [];

        // Place Details returns at most 5 reviews per request; UI supports up to 15 for future sources.
        $reviews = array_slice($result['reviews'] ?? [], 0, 15);

        $data = [
            'reviews' => $reviews,
            'place_name' => $result['name'] ?? null,
            'overall_rating' => isset($result['rating']) ? (float) $result['rating'] : null,
            'user_ratings_total' => isset($result['user_ratings_total']) ? (int) $result['user_ratings_total'] : null,
            'api_status' => 'OK',
            'api_error_message' => null,
        ];

        Cache::put($cacheKey, $data, 3600);

        return $data;
    }
}
