<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $productCategories = ProductCategory::latest()->get();
       return view('backend.product_categories.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
        return view('backend.product_categories.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:product_categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'slug']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_categories', 'public');
            $data['image'] = $imagePath;
        }

        ProductCategory::create($data);

        return redirect()->route('backend.product-categories.index')->with('success', 'Product category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        return view('backend.product_categories.create_edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:product_categories,slug,' . $productCategory->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'slug']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($productCategory->image) {
                \Storage::disk('public')->delete($productCategory->image);
            }
            $imagePath = $request->file('image')->store('product_categories', 'public');
            $data['image'] = $imagePath;
        }

        $productCategory->update($data);

        return redirect()->route('backend.product-categories.index')->with('success', 'Product category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        // Delete associated image if exists
        if ($productCategory->image) {
            \Storage::disk('public')->delete($productCategory->image);
        }

        $productCategory->delete();

        return redirect()->route('backend.product-categories.index')->with('success', 'Product category deleted successfully.');
    }
}
