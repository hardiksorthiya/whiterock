<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\CatalogueDownload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatalogueDownloadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'catalogue_id' => 'required|integer|exists:catalogues,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:64',
            'city' => 'required|string|max:120',
        ]);

        $catalogue = Catalogue::query()
            ->where('is_active', true)
            ->whereNotNull('pdf')
            ->find($validated['catalogue_id']);

        if ($catalogue === null) {
            return response()->json([
                'message' => 'This catalogue is not available for download.',
            ], 422);
        }

        CatalogueDownload::create([
            'catalogue_id' => $catalogue->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'ok' => true,
            'pdf_url' => asset('storage/'.$catalogue->pdf),
        ]);
    }
}
