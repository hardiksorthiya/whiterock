<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\ProductApplication;
use Illuminate\Http\Request;
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
                if (empty($ids) && !empty($app->gallery_category_id)) {
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
            if (empty($ids) && !empty($app->gallery_category_id)) {
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
        ]);

        $ids = array_values(array_map('intval', $validated['gallery_category_ids']));

        ProductApplication::create([
            'name' => $validated['name'],
            // Keep existing column filled (table has a non-null FK). Use first selection as primary.
            'gallery_category_id' => $ids[0],
            'gallery_category_ids' => $ids,
        ]);

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
        ]);

        $ids = array_values(array_map('intval', $validated['gallery_category_ids']));

        $application->update([
            'name' => $validated['name'],
            'gallery_category_id' => $ids[0],
            'gallery_category_ids' => $ids,
        ]);

        return redirect()->route('backend.applications.index')
            ->with('success', 'Application updated successfully.');
    }

    public function destroy(ProductApplication $application)
    {
        $application->delete();

        return redirect()->route('backend.applications.index')
            ->with('success', 'Application deleted successfully.');
    }
}

