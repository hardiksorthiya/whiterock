<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $products = Product::with('categories')
            ->latest()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%'.addcslashes($search, '%_\\').'%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('backend.products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        $defaultCategory = ProductCategory::where('is_active', true)->orderBy('name')->first();

        return view('backend.products.create_edit', [
            'categories' => $categories,
            'defaultCategory' => $defaultCategory,
            'product' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:product_categories,id',
        ]);

        $data = $request->only([
            'name',
            'slug',
            'sku',
            'short_description',
            'long_description',
            'meta_title',
            'meta_description',
            'keywords',
            'is_active',
        ]);

        $categoryIds = $this->normalizedCategoryIds($request);
        if ($categoryIds === []) {
            return back()
                ->withErrors([
                    'category_ids' => 'Select at least one category or set a default category under Product Categories.',
                ])
                ->withInput();
        }

        $data['category_id'] = $categoryIds[0];
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('products/featured', 'public');
        }

        $product = Product::create($data);
        $product->categories()->sync($categoryIds);
        $this->storeGalleryUploads($request, $product);

        return redirect()->route('backend.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with(['images', 'categories'])->findOrFail($id);
        $categories = ProductCategory::orderBy('name')->get();
        $defaultCategory = ProductCategory::where('is_active', true)->orderBy('name')->first();

        return view('backend.products.create_edit', compact('product', 'categories', 'defaultCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,'.$product->id,
            'sku' => 'nullable|string|max:255|unique:products,sku,'.$product->id,
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'remove_gallery_ids' => 'nullable|array',
            'remove_gallery_ids.*' => 'integer|exists:product_images,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:product_categories,id',
        ]);

        $data = $request->only([
            'name',
            'slug',
            'sku',
            'short_description',
            'long_description',
            'meta_title',
            'meta_description',
            'keywords',
            'is_active',
        ]);

        $categoryIds = $this->normalizedCategoryIds($request);
        if ($categoryIds === []) {
            return back()
                ->withErrors([
                    'category_ids' => 'Select at least one category or set a default category under Product Categories.',
                ])
                ->withInput();
        }

        $data['category_id'] = $categoryIds[0];
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        if ($request->hasFile('featured_image')) {
            // Delete old featured image if exists
            if ($product->featured_image) {
                Storage::disk('public')->delete($product->featured_image);
            }
            $featuredImagePath = $request->file('featured_image')->store('products/featured', 'public');
            $data['featured_image'] = $featuredImagePath;
        }

        $product->update($data);
        $product->categories()->sync($categoryIds);

        $this->removeGalleryImages($request, $product);
        $this->storeGalleryUploads($request, $product);

        return redirect()->route('backend.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::with('images')->findOrFail($id);

        // Delete images if exist
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }
        foreach ($product->images as $galleryImage) {
            Storage::disk('public')->delete($galleryImage->image);
        }

        $product->delete();

        return redirect()->route('backend.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Handle bulk actions for products.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $action = $validated['action'];
        $productIds = $validated['product_ids'];

        switch ($action) {
            case 'activate':
                Product::whereIn('id', $productIds)->update(['is_active' => true]);

                return redirect()->route('backend.products.index')->with('success', 'Selected products activated successfully.');
            case 'deactivate':
                Product::whereIn('id', $productIds)->update(['is_active' => false]);

                return redirect()->route('backend.products.index')->with('success', 'Selected products deactivated successfully.');
            case 'delete':
                $products = Product::with('images')->whereIn('id', $productIds)->get();
                foreach ($products as $product) {
                    if ($product->image) {
                        Storage::disk('public')->delete($product->image);
                    }
                    if ($product->featured_image) {
                        Storage::disk('public')->delete($product->featured_image);
                    }
                    foreach ($product->images as $galleryImage) {
                        Storage::disk('public')->delete($galleryImage->image);
                    }
                    $product->delete();
                }

                return redirect()->route('backend.products.index')->with('success', 'Selected products deleted successfully.');
            default:
                return redirect()->route('backend.products.index')->with('error', 'Invalid action selected.');
        }
    }

    protected function storeGalleryUploads(Request $request, Product $product): void
    {
        if (! $request->hasFile('gallery_images')) {
            return;
        }

        $baseOrder = (int) $product->images()->max('sort_order');

        foreach ($request->file('gallery_images') as $index => $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }
            $path = $file->store('products/gallery', 'public');
            $product->images()->create([
                'image' => $path,
                'sort_order' => $baseOrder + $index + 1,
            ]);
        }
    }

    protected function removeGalleryImages(Request $request, Product $product): void
    {
        $ids = $request->input('remove_gallery_ids', []);
        if ($ids === [] || $ids === null) {
            return;
        }

        $images = ProductImage::where('product_id', $product->id)
            ->whereIn('id', $ids)
            ->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }
    }

    /**
     * @return list<int>
     */
    protected function normalizedCategoryIds(Request $request): array
    {
        $raw = $request->input('category_ids', []);
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $raw))));
        if ($ids !== []) {
            return $ids;
        }

        $defaultId = ProductCategory::getDefaultId();

        return $defaultId !== null ? [$defaultId] : [];
    }
}
