<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\CatalogueCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $catalogues = Catalogue::with('category')
            ->latest()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%'.addcslashes($search, '%_\\').'%');
            })
            ->paginate(10)
            ->withQueryString();
        return view('backend.catalogue.index', compact('catalogues', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CatalogueCategory::query()->orderBy('name')->get();

        return view('backend.catalogue.create_edit', [
            'catalogue' => null,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf',
            'category_id' => 'required|exists:catalogue_categories,id',
            'is_active' => 'nullable|boolean',
        ]);

        $pdfPath = $request->file('pdf')->store('catalogues', 'public');

        Catalogue::create([
            'name' => $request->name,
            'pdf' => $pdfPath,
            'category_id' => $request->category_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('backend.catalogues.index')->with('success', 'Catalogue created successfully');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $catalogue = Catalogue::findOrFail($id);
        $categories = CatalogueCategory::query()->orderBy('name')->get();

        return view('backend.catalogue.create_edit', compact('catalogue', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $catalogue = Catalogue::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf',
            'category_id' => 'required|exists:catalogue_categories,id',
            'is_active' => 'nullable|boolean',
        ]);

        $catalogue->name = $request->name;
        $catalogue->category_id = $request->category_id;
        $catalogue->is_active = $request->boolean('is_active', true);

        if ($request->hasFile('pdf')) {
            if ($catalogue->pdf) {
                Storage::disk('public')->delete($catalogue->pdf);
            }
            $catalogue->pdf = $request->file('pdf')->store('catalogues', 'public');
        }

        $catalogue->save();

        return redirect()->route('backend.catalogues.index')->with('success', 'Catalogue updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $catalogue = Catalogue::findOrFail($id);

        if ($catalogue->pdf) {
            Storage::disk('public')->delete($catalogue->pdf);
        }

        $catalogue->delete();

        return redirect()->route('backend.catalogues.index')->with('success', 'Catalogue deleted successfully');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete',
            'catalogue_ids' => 'required|array|min:1',
            'catalogue_ids.*' => 'integer|exists:catalogues,id',
        ]);

        if ($validated['action'] === 'delete') {
            $this->deleteCatalogues($validated['catalogue_ids']);

            return redirect()->route('backend.catalogues.index')->with('success', 'Selected catalogues deleted successfully.');
        }

        return redirect()->route('backend.catalogues.index')->with('error', 'Invalid action selected.');
    }

    protected function deleteCatalogues(array $ids): void
    {
        $catalogues = Catalogue::query()->whereIn('id', $ids)->get();
        foreach ($catalogues as $catalogue) {
            if ($catalogue->pdf) {
                Storage::disk('public')->delete($catalogue->pdf);
            }
            $catalogue->delete();
        }
    }
}
