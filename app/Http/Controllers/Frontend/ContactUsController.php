<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use App\Mail\ContactUsSubmittedMail;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string|max:5000',
            'phone' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:255',
        ]);

        ContactEnquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'phone' => $validated['phone'] ?? null,
            'city' => $validated['city'] ?? null,
            'message' => $validated['message'] ?? null,
        ]);

        $toAddress = trim((string) env('MAIL_TO_ADDRESS', ''));
        if ($toAddress === '') {
            $siteEmail = trim((string) optional(Setting::site())->email);
            $toAddress = $siteEmail !== '' ? $siteEmail : trim((string) config('mail.from.address', ''));
        }

        if ($toAddress !== '') {
            Mail::to($toAddress)->send(new ContactUsSubmittedMail($validated));
        }

        return back()->with('success', 'Your message has been submitted successfully.');
    }
}

