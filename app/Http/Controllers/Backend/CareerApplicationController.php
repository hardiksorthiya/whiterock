<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CareerApplicationController extends Controller
{
    public function index(): View
    {
        $entries = CareerApplication::query()
            ->latest()
            ->paginate(20);

        return view('backend.career_applications.index', compact('entries'));
    }

    public function downloadCv(CareerApplication $careerApplication): StreamedResponse
    {
        $path = $careerApplication->cv_path;
        if ($path === null || $path === '' || ! str_starts_with($path, 'career-cvs/')) {
            abort(404);
        }

        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $downloadName = pathinfo($path, PATHINFO_BASENAME);

        return Storage::disk('public')->download($path, $downloadName);
    }
}
