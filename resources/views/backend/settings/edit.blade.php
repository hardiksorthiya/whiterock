@extends('layouts.app')

@section('page_title', 'Site settings')
@section('page_subtitle', 'Logo, light logo, favicon, social links, contact & footer')

@section('content')

    @if (session('success'))
        <div class="adm-alert adm-alert--ok">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="adm-alert adm-alert--err">
            @foreach ($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('backend.settings.update') }}" class="row g-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="col-lg-8">

            <section class="adm-card">
                <h2 class="adm-card__title">Branding</h2>
                <div class="adm-card__body">
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="logo" class="form-control" accept="image/*,.svg">
                        @if ($setting->logo_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$setting->logo_path) }}" alt="Current logo" style="max-height: 64px;">
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Light logo</label>
                        <p class="text-muted small mb-2">Optional. Use a light or white version for the transparent header over dark areas; the main logo is shown when the header has a solid background (e.g. after scroll).</p>
                        <input type="file" name="light_logo" class="form-control" accept="image/*,.svg">
                        @if ($setting->light_logo_path)
                            <div class="mt-2 p-3 rounded" style="background: #2a2a2a;">
                                <img src="{{ asset('storage/'.$setting->light_logo_path) }}" alt="Current light logo" style="max-height: 64px;">
                            </div>
                        @endif
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Favicon</label>
                        <input type="file" name="favicon" class="form-control" accept=".ico,image/*">
                        @if ($setting->favicon_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$setting->favicon_path) }}" alt="Favicon" width="32" height="32" class="border rounded">
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section class="adm-card mt-3">
                <h2 class="adm-card__title">Social media</h2>
                <div class="adm-card__body">
                    <div class="mb-3">
                        <label class="form-label">Facebook URL</label>
                        <input type="text" name="facebook_url" class="form-control"
                            value="{{ old('facebook_url', $setting->facebook_url) }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instagram URL</label>
                        <input type="text" name="instagram_url" class="form-control"
                            value="{{ old('instagram_url', $setting->instagram_url) }}" placeholder="https://instagram.com/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Twitter / X URL</label>
                        <input type="text" name="twitter_url" class="form-control"
                            value="{{ old('twitter_url', $setting->twitter_url) }}" placeholder="https://x.com/...">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">WhatsApp link</label>
                        <input type="text" name="whatsapp_url" class="form-control"
                            value="{{ old('whatsapp_url', $setting->whatsapp_url) }}"
                            placeholder="https://wa.me/1234567890">
                    </div>
                </div>
            </section>

            <section class="adm-card mt-3">
                <h2 class="adm-card__title">Contact</h2>
                <div class="adm-card__body">
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $setting->phone) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $setting->email) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="contact_address" class="form-control" rows="3">{{ old('contact_address', $setting->contact_address) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location iframe (embed HTML)</label>
                        <textarea name="contact_map_iframe" class="form-control font-monospace small" rows="4"
                            placeholder="&lt;iframe src=&quot;...&quot;&gt;&lt;/iframe&gt;">{{ old('contact_map_iframe', $setting->contact_map_iframe) }}</textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Contact background image</label>
                        <input type="file" name="contact_background_image" class="form-control"
                            accept="image/*">
                        @if (!empty($setting->contact_background_image_path))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $setting->contact_background_image_path) }}"
                                    alt="Contact background" style="max-height: 120px; width: auto;"
                                    class="rounded border">
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section class="adm-card mt-3">
                <h2 class="adm-card__title">Google Maps</h2>
                <div class="adm-card__body">
                    <div class="mb-3">
                        <label class="form-label">Google API Key</label>
                        <input type="text" name="google_api_key" class="form-control"
                            value="{{ old('google_api_key', $setting->google_api_key) }}" placeholder="Your Google API key">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Google Place ID</label>
                        <input type="text" name="google_place_id" class="form-control"
                            value="{{ old('google_place_id', $setting->google_place_id) }}" placeholder="Google Place ID for your business/location">
                    </div>
                </div>  
            </section>

            <section class="adm-card mt-3">
                <h2 class="adm-card__title">Footer</h2>
                <div class="adm-card__body">
                    <label class="form-label">Footer description text</label>
                    <textarea id="footer_text" name="footer_text" class="form-control" rows="4"
                        placeholder="Copyright, tagline, legal notice…">{{ old('footer_text', $setting->footer_text) }}</textarea>
                    <hr class="my-3">
                    <label class="form-label">Footer copyright text</label>
                    <textarea id="footer_copyright_text" name="footer_copyright_text" class="form-control" rows="3"
                        placeholder="Copyright © 2026. All rights reserved.">{{ old('footer_copyright_text', $setting->footer_copyright_text) }}</textarea>
                </div>
            </section>
        </div>

        <div class="col-lg-4 adm-sidebar-col">
            <section class="adm-card">
                <h2 class="adm-card__title">Save</h2>
                <div class="adm-card__body">
                    <button type="submit" class="adm-btn adm-btn--primary w-100">Save settings</button>
                </div>
            </section>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        (function () {
            if (typeof CKEDITOR !== 'undefined' && document.getElementById('footer_text') && !CKEDITOR.instances.footer_text) {
                CKEDITOR.replace('footer_text');
            }
            if (typeof CKEDITOR !== 'undefined' && document.getElementById('footer_copyright_text') && !CKEDITOR.instances.footer_copyright_text) {
                CKEDITOR.replace('footer_copyright_text');
            }
        })();
    </script>
@endpush
