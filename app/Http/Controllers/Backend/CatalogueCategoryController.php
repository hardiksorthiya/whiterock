<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CatalogueCategory;
use Illuminate\Http\Request;

class CatalogueCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $categories = CatalogueCategory::query()
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

        return view('backend.catalogue.category.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.catalogue.category.create_edit', ['category' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:catalogue_categories',
        ]);
        $category = CatalogueCategory::create($request->all());
        return redirect()->route('backend.catalogue-categories.index')->with('success', 'Category created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = CatalogueCategory::find($id);
        return view('backend.catalogue.category.create_edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:catalogue_categories,slug,'.$id,
        ]);
        $category = CatalogueCategory::find($id);
        $category->update($request->all());
        return redirect()->route('backend.catalogue-categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CatalogueCategory::find($id);
        $category->delete();
        return redirect()->route('backend.catalogue-categories.index')->with('success', 'Category deleted successfully');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'integer|exists:catalogue_categories,id',
        ]);

        $action = $validated['action'];
        $ids = $validated['category_ids'];

        switch ($action) {
            case 'delete':
                CatalogueCategory::whereIn('id', $ids)->delete();

                return redirect()->route('backend.catalogue-categories.index')->with('success', 'Selected categories deleted successfully.');
            default:
                return redirect()->route('backend.catalogue-categories.index')->with('error', 'Invalid action selected.');
        }
    }
}
