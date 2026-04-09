<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $sliders = Slider::query()
            ->latest()
            ->when($search, function ($query, $search) {
                $s = addcslashes($search, '%_\\');
                $query->where('title', 'like', '%'.$s.'%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('backend.sliders.index', compact('sliders', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.sliders.create_edit', [
            'slider' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'required|image|max:5120',
            'image_mobile' => 'nullable|image|max:5120',
            'is_active' => ['required', Rule::in(['0', '1'])],
            'show_button' => 'boolean',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:2048',
            'show_video' => 'boolean',
            'video_link' => 'nullable|string|max:2048',
        ]);

        $data = $request->only([
            'title', 'description', 'button_text', 'button_link', 'video_link',
        ]);
        $data = $this->nullableStringFields($data, ['title', 'description']);

        $data['is_active'] = $request->input('is_active') === '1';
        $data['show_button'] = $request->boolean('show_button');
        $data['show_video'] = $request->boolean('show_video');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        if ($request->hasFile('image_mobile')) {
            $data['image_mobile'] = $request->file('image_mobile')->store('sliders', 'public');
        }

        Slider::create($data);

        return redirect()->route('backend.sliders.index')
            ->with('success', __('Slider created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);

        return view('backend.sliders.create_edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'image_mobile' => 'nullable|image|max:5120',
            'is_active' => ['required', Rule::in(['0', '1'])],
            'show_button' => 'boolean',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:2048',
            'show_video' => 'boolean',
            'video_link' => 'nullable|string|max:2048',
        ]);

        $data = $request->only([
            'title', 'description', 'button_text', 'button_link', 'video_link',
        ]);
        $data = $this->nullableStringFields($data, ['title', 'description']);

        $data['is_active'] = $request->input('is_active') === '1';
        $data['show_button'] = $request->boolean('show_button');
        $data['show_video'] = $request->boolean('show_video');

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        if ($request->hasFile('image_mobile')) {
            if ($slider->image_mobile) {
                Storage::disk('public')->delete($slider->image_mobile);
            }
            $data['image_mobile'] = $request->file('image_mobile')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('backend.sliders.index')
            ->with('success', __('Slider updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        if ($slider->image_mobile) {
            Storage::disk('public')->delete($slider->image_mobile);
        }
        $slider->delete();

        return redirect()->route('backend.sliders.index')
            ->with('success', __('Slider deleted successfully.'));
    }

    /**
     * @param  list<string>  $keys
     * @return array<string, mixed>
     */
    private function nullableStringFields(array $data, array $keys): array
    {
        foreach ($keys as $key) {
            $v = $data[$key] ?? null;
            $data[$key] = ($v !== null && trim((string) $v) !== '') ? trim((string) $v) : null;
        }

        return $data;
    }
}
