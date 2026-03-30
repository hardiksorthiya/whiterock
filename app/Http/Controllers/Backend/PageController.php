<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('backend.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'layout' => 'required|in:default,faq',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'description' => 'nullable|string',
            'faq_items' => 'nullable|array',
            'faq_items.*.question' => 'nullable|string|max:1000|required_with:faq_items.*.answer',
            'faq_items.*.answer' => 'nullable|string|max:10000|required_with:faq_items.*.question',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->only([
            'title',
            'layout',
            'slug',
            'description',
            'meta_title',
            'meta_description',
            'keywords',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['faq_items'] = $this->sanitizeFaqItems($request->input('faq_items', []), $request->input('layout')) ?: null;

        Page::create($data);

        return redirect()->route('backend.pages.index')->with('success', 'Page created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Page::findOrFail($id);
        return view('backend.pages.create_edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'layout' => 'required|in:default,faq',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'description' => 'nullable|string',
            'faq_items' => 'nullable|array',
            'faq_items.*.question' => 'nullable|string|max:1000|required_with:faq_items.*.answer',
            'faq_items.*.answer' => 'nullable|string|max:10000|required_with:faq_items.*.question',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->only([
            'title',
            'layout',
            'slug',
            'description',
            'meta_title',
            'meta_description',
            'keywords',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['faq_items'] = $this->sanitizeFaqItems($request->input('faq_items', []), $request->input('layout')) ?: null;

        $page->update($data);

        return redirect()->route('backend.pages.index')->with('success', 'Page updated successfully.');
    }

    protected function sanitizeFaqItems($faqItems, ?string $layout): array
    {
        if ($layout !== 'faq') {
            return [];
        }

        return collect(is_array($faqItems) ? $faqItems : [])
            ->map(function ($item) {
                return [
                    'question' => trim((string) ($item['question'] ?? '')),
                    'answer' => trim((string) ($item['answer'] ?? '')),
                ];
            })
            ->filter(fn ($item) => $item['question'] !== '' || $item['answer'] !== '')
            ->values()
            ->all();
    }
}
