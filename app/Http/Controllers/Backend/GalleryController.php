<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        $categories = GalleryCategory::query()
            ->with('images')
            ->latest()
            ->when($search, function ($query, $search) {
                $s = addcslashes($search, '%_\\');
                $query->where('name', 'like', '%'.$s.'%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('backend.gallery.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.gallery.create_edit', ['category' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $category = GalleryCategory::create(['name' => $request->name]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('gallery_images', 'public');
                GalleryImage::create([
                    'category_id' => $category->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('backend.gallery.index')->with('success', 'Gallery category created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = GalleryCategory::with('images')->findOrFail($id);
        return view('backend.gallery.create_edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'remove_gallery_image_ids' => 'nullable|array',
            'remove_gallery_image_ids.*' => 'integer|exists:gallery_images,id',
        ]);

        $category = GalleryCategory::findOrFail($id);
        $category->update(['name' => $request->name]);

        $removeIds = $request->input('remove_gallery_image_ids', []);
        if (is_array($removeIds) && $removeIds !== []) {
            $imagesToRemove = GalleryImage::query()
                ->where('category_id', $category->id)
                ->whereIn('id', $removeIds)
                ->get();

            foreach ($imagesToRemove as $galleryImage) {
                if ($galleryImage->image) {
                    Storage::disk('public')->delete($galleryImage->image);
                }
                $galleryImage->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('gallery_images', 'public');
                GalleryImage::create([
                    'category_id' => $category->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('backend.gallery.index')->with('success', 'Gallery category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = GalleryCategory::with('images')->findOrFail($id);

        // Cleanup uploaded files as well (DB rows are removed by cascade).
        foreach ($category->images as $galleryImage) {
            if ($galleryImage->image) {
                Storage::disk('public')->delete($galleryImage->image);
            }
        }

        $category->delete();

        return redirect()->route('backend.gallery.index')->with('success', 'Gallery category deleted successfully.');
    }
}
