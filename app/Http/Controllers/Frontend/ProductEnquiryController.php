<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ProductEnquirySubmittedMail;
use App\Models\Product;
use App\Models\ProductEnquiry;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductEnquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'quantity' => 'required|integer|min:1|max:1000000',
            'message' => 'nullable|string|max:5000',
        ]);

        $product = Product::query()
            ->where('is_active', true)
            ->findOrFail((int) $validated['product_id']);

        $enquiry = ProductEnquiry::create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'quantity' => (int) $validated['quantity'],
            'message' => $validated['message'] ?? null,
        ]);

        $toAddress = trim((string) env('MAIL_TO_ADDRESS', ''));
        if ($toAddress === '') {
            $siteEmail = trim((string) optional(Setting::site())->email);
            $toAddress = $siteEmail !== '' ? $siteEmail : trim((string) config('mail.from.address', ''));
        }

        if ($toAddress !== '') {
            Mail::to($toAddress)->send(new ProductEnquirySubmittedMail($enquiry));
        }

        return back()->with('success', 'Your enquiry has been submitted successfully.');
    }
}
