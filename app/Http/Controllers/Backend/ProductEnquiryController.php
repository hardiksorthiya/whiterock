<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductEnquiry;
use Illuminate\View\View;

class ProductEnquiryController extends Controller
{
    public function index(): View
    {
        $entries = ProductEnquiry::query()
            ->latest()
            ->paginate(20);

        return view('backend.enquiery_entries.index', compact('entries'));
    }
}
