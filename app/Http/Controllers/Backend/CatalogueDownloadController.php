<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CatalogueDownload;
use Illuminate\View\View;

class CatalogueDownloadController extends Controller
{
    public function index(): View
    {
        $downloads = CatalogueDownload::query()
            ->with(['catalogue.category'])
            ->latest()
            ->paginate(20);

        return view('backend.catalogue_downloads.index', compact('downloads'));
    }
}
