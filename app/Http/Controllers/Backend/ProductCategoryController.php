<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $search = request('search');
        $productCategories = ProductCategory::query()
            ->select('product_categories.*')
            ->selectRaw('(
                SELECT COUNT(DISTINCT p.id)
                FROM products p
                WHERE p.category_id = product_categories.id
                   OR EXISTS (
                       SELECT 1 FROM product_product_category ppc
                       WHERE ppc.product_id = p.id
                         AND ppc.product_category_id = product_categories.id
                   )
            ) as products_count')
            ->latest()
            ->when($search, function ($query, $search) {
                $s = addcslashes($search, '%_\\');
                $query->where(function ($q) use ($s) {
                    $q->where('name', 'like', '%'.$s.'%')
                        ->orWhere('slug', 'like', '%'.$s.'%');
                });
            })
            ->paginate(10)
            ->withQueryString();

        return view('backend.product_categories.index', compact('productCategories', 'search'));
    }

    public function create()
    {
        return view('backend.product_categories.create_edit', ['productCategory' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:product_categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'slug']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product_categories', 'public');
        }

        ProductCategory::create($data);

        return redirect()->route('backend.product-categories.index')->with('success', 'Product category created successfully.');
    }

    public function edit(string $id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        return view('backend.product_categories.create_edit', compact('productCategory'));
    }

    public function update(Request $request, string $id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:product_categories,slug,'.$productCategory->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'slug']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($productCategory->image) {
                Storage::disk('public')->delete($productCategory->image);
            }
            $data['image'] = $request->file('image')->store('product_categories', 'public');
        }

        $productCategory->update($data);

        return redirect()->route('backend.product-categories.index')->with('success', 'Product category updated successfully.');
    }

    public function destroy(string $id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        if ($productCategory->image) {
            Storage::disk('public')->delete($productCategory->image);
        }

        $productCategory->delete();

        return redirect()->route('backend.product-categories.index')->with('success', 'Product category deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'integer|exists:product_categories,id',
        ]);

        $action = $validated['action'];
        $ids = $validated['category_ids'];

        switch ($action) {
            case 'activate':
                ProductCategory::whereIn('id', $ids)->update(['is_active' => true]);

                return redirect()->route('backend.product-categories.index')->with('success', 'Selected categories activated successfully.');
            case 'deactivate':
                ProductCategory::whereIn('id', $ids)->update(['is_active' => false]);

                return redirect()->route('backend.product-categories.index')->with('success', 'Selected categories deactivated successfully.');
            case 'delete':
                $categories = ProductCategory::whereIn('id', $ids)->get();
                foreach ($categories as $category) {
                    if ($category->image) {
                        Storage::disk('public')->delete($category->image);
                    }
                    $category->delete();
                }

                return redirect()->route('backend.product-categories.index')->with('success', 'Selected categories deleted successfully.');
            default:
                return redirect()->route('backend.product-categories.index')->with('error', 'Invalid action selected.');
        }
    }
}
