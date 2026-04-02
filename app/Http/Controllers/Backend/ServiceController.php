<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $services = Service::query()
            ->latest()
            ->when($search, function ($query, $search) {
                $s = addcslashes($search, '%_\\');
                $query->where('title', 'like', '%'.$s.'%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('backend.services.index', compact('services', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.services.create_edit', [
            'service' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|image|max:5120',
            'background_image' => 'nullable|image|max:5120',
            'is_active' => ['required', Rule::in(['0', '1'])],
        ]);

        $data = $request->only(['title', 'description']);
        $data['is_active'] = $request->input('is_active') === '1';

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('services', 'public');
        }

        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('backend.services.index')
            ->with('success', __('Service created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('backend.services.create_edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|max:5120',
            'background_image' => 'nullable|image|max:5120',
            'is_active' => ['required', Rule::in(['0', '1'])],
        ]);

        $data = $request->only(['title', 'description']);
        $data['is_active'] = $request->input('is_active') === '1';

        if ($request->hasFile('icon')) {
            if ($service->icon) {
                Storage::disk('public')->delete($service->icon);
            }
            $data['icon'] = $request->file('icon')->store('services', 'public');
        }

        if ($request->hasFile('background_image')) {
            if ($service->background_image) {
                Storage::disk('public')->delete($service->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('backend.services.index')
            ->with('success', __('Service updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->icon) {
            Storage::disk('public')->delete($service->icon);
        }
        if ($service->background_image) {
            Storage::disk('public')->delete($service->background_image);
        }

        $service->delete();

        return redirect()->route('backend.services.index')
            ->with('success', __('Service deleted successfully.'));
    }
}
