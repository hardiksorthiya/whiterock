<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\View\View;

class ContactEnquiryController extends Controller
{
    public function index(): View
    {
        $entries = ContactEnquiry::query()
            ->latest()
            ->paginate(20);

        return view('backend.contact_entries.index', compact('entries'));
    }
}

