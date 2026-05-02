<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\ProductApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductApplicationController extends Controller
{
    public function index(): View
    {
        $applications = ProductApplication::query()
            ->with('galleryCategory')
            ->latest()
            ->paginate(20);

        // Build display string for multi-selected gallery categories.
        $allCategoryIds = $applications
            ->flatMap(function ($app) {
                $ids = $app->gallery_category_ids ?? [];
                if (empty($ids) && ! empty($app->gallery_category_id)) {
                    $ids = [$app->gallery_category_id];
                }

                return is_array($ids) ? $ids : [];
            })
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $categoriesById = GalleryCategory::query()
            ->whereIn('id', $allCategoryIds)
            ->get()
            ->keyBy('id');

        $applications->getCollection()->transform(function ($app) use ($categoriesById) {
            $ids = $app->gallery_category_ids ?? [];
            if (empty($ids) && ! empty($app->gallery_category_id)) {
                $ids = [$app->gallery_category_id];
            }

            $ids = is_array($ids) ? $ids : [];
            $names = collect($ids)
                ->map(fn ($id) => optional($categoriesById->get((int) $id))->name)
                ->filter()
                ->values();

            $app->gallery_category_names = $names->implode(', ');

            return $app;
        });

        return view('backend.applications.index', compact('applications'));
    }

    public function create(): View
    {
        return view('backend.applications.create_edit', [
            'application' => null,
            'categories' => GalleryCategory::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gallery_category_ids' => 'required|array|min:1',
            'gallery_category_ids.*' => 'required|integer|exists:gallery_categories,id',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $ids = array_values(array_map('intval', $validated['gallery_category_ids']));

        $data = [
            'name' => $validated['name'],
            'gallery_category_id' => $ids[0],
            'gallery_category_ids' => $ids,
        ];

        if ($request->hasFile('feature_image')) {
            $data['feature_image'] = $request->file('feature_image')->store('applications/feature', 'public');
        }

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('applications/banner', 'public');
        }

        ProductApplication::create($data);

        return redirect()->route('backend.applications.index')
            ->with('success', 'Application created successfully.');
    }

    public function edit(ProductApplication $application): View
    {
        return view('backend.applications.create_edit', [
            'application' => $application,
            'categories' => GalleryCategory::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, ProductApplication $application)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gallery_category_ids' => 'required|array|min:1',
            'gallery_category_ids.*' => 'required|integer|exists:gallery_categories,id',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'remove_feature_image' => 'nullable|boolean',
            'remove_banner_image' => 'nullable|boolean',
        ]);

        $ids = array_values(array_map('intval', $validated['gallery_category_ids']));

        $application->name = $validated['name'];
        $application->gallery_category_id = $ids[0];
        $application->gallery_category_ids = $ids;

        if ($request->boolean('remove_feature_image') && $application->feature_image) {
            Storage::disk('public')->delete($application->feature_image);
            $application->feature_image = null;
        } elseif ($request->hasFile('feature_image')) {
            if ($application->feature_image) {
                Storage::disk('public')->delete($application->feature_image);
            }
            $application->feature_image = $request->file('feature_image')->store('applications/feature', 'public');
        }

        if ($request->boolean('remove_banner_image') && $application->banner_image) {
            Storage::disk('public')->delete($application->banner_image);
            $application->banner_image = null;
        } elseif ($request->hasFile('banner_image')) {
            if ($application->banner_image) {
                Storage::disk('public')->delete($application->banner_image);
            }
            $application->banner_image = $request->file('banner_image')->store('applications/banner', 'public');
        }

        $application->save();

        return redirect()->route('backend.applications.index')
            ->with('success', 'Application updated successfully.');
    }

    public function destroy(ProductApplication $application)
    {
        if ($application->feature_image) {
            Storage::disk('public')->delete($application->feature_image);
        }
        if ($application->banner_image) {
            Storage::disk('public')->delete($application->banner_image);
        }

        $application->delete();

        return redirect()->route('backend.applications.index')
            ->with('success', 'Application deleted successfully.');
    }
}
