<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductFeatureController extends Controller
{
    public function index()
    {
        $search = request('search');
        $features = ProductFeature::query()
            ->when($search, function ($query, $search) {
                $s = addcslashes($search, '%_\\');
                $query->where('title', 'like', '%'.$s.'%');
            })
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('backend.product_features.index', compact('features', 'search'));
    }

    public function create()
    {
        return view('backend.product_features.create_edit', ['feature' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0|max:99999',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'sort_order' => (int) $request->input('sort_order', 0),
            'image' => $request->file('image')->store('product-features', 'public'),
        ];

        ProductFeature::create($data);

        return redirect()->route('backend.product-features.index')
            ->with('success', 'Product feature created successfully.');
    }

    public function edit(string $id)
    {
        $feature = ProductFeature::findOrFail($id);

        return view('backend.product_features.create_edit', compact('feature'));
    }

    public function update(Request $request, string $id)
    {
        $feature = ProductFeature::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0|max:99999',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $feature->title = $request->title;
        $feature->sort_order = (int) $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            if ($feature->image) {
                Storage::disk('public')->delete($feature->image);
            }
            $feature->image = $request->file('image')->store('product-features', 'public');
        }

        $feature->save();

        return redirect()->route('backend.product-features.index')
            ->with('success', 'Product feature updated successfully.');
    }

    public function destroy(string $id)
    {
        $feature = ProductFeature::findOrFail($id);

        if ($feature->image) {
            Storage::disk('public')->delete($feature->image);
        }

        $feature->delete();

        return redirect()->route('backend.product-features.index')
            ->with('success', 'Product feature deleted successfully.');
    }
}
