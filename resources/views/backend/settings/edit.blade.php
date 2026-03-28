@extends('layouts.app')

@section('page_title', 'Site settings')
@section('page_subtitle', 'Logo, favicon, social links, contact & footer')

@php
    $locations = old('contact_locations', $setting->contact_locations ?? []);
    if (! is_array($locations)) {
        $locations = [];
    }
    if (count($locations) === 0) {
        $locations = [['title' => '', 'description' => '', 'map_iframe' => '']];
    }
@endphp

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

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">Locations (title, description, map iframe)</label>
                        <button type="button" class="adm-btn adm-btn--ghost adm-btn--sm" id="addLocationRow">
                            <i class="bi bi-plus-lg"></i> Add location
                        </button>
                    </div>

                    <div id="contactLocations" class="d-flex flex-column gap-3">
                        @foreach ($locations as $i => $loc)
                            <div class="contact-location-block border rounded p-3 position-relative">
                                <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 remove-location"
                                    title="Remove" aria-label="Remove location">&times;</button>
                                <div class="mb-2">
                                    <label class="form-label small text-muted mb-0">Title</label>
                                    <input type="text" name="contact_locations[{{ $i }}][title]" class="form-control"
                                        value="{{ old('contact_locations.'.$i.'.title', $loc['title'] ?? '') }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small text-muted mb-0">Description</label>
                                    <textarea name="contact_locations[{{ $i }}][description]" class="form-control" rows="2">{{ old('contact_locations.'.$i.'.description', $loc['description'] ?? '') }}</textarea>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small text-muted mb-0">Map iframe (embed HTML)</label>
                                    <textarea name="contact_locations[{{ $i }}][map_iframe]" class="form-control font-monospace small" rows="3"
                                        placeholder="&lt;iframe src=&quot;...&quot;&gt;&lt;/iframe&gt;">{{ old('contact_locations.'.$i.'.map_iframe', $loc['map_iframe'] ?? '') }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="adm-card mt-3">
                <h2 class="adm-card__title">Footer</h2>
                <div class="adm-card__body">
                    <label class="form-label">Footer text</label>
                    <textarea name="footer_text" class="form-control" rows="4"
                        placeholder="Copyright, tagline, legal notice…">{{ old('footer_text', $setting->footer_text) }}</textarea>
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
    <script>
        (function () {
            const container = document.getElementById('contactLocations');
            const addBtn = document.getElementById('addLocationRow');
            if (!container || !addBtn) return;

            function nextIndex() {
                return container.querySelectorAll('.contact-location-block').length;
            }

            function bindRemove(block) {
                const btn = block.querySelector('.remove-location');
                if (btn) {
                    btn.addEventListener('click', function () {
                        if (container.querySelectorAll('.contact-location-block').length <= 1) {
                            block.querySelectorAll('input, textarea').forEach(function (el) { el.value = ''; });
                            return;
                        }
                        block.remove();
                    });
                }
            }

            container.querySelectorAll('.contact-location-block').forEach(bindRemove);

            addBtn.addEventListener('click', function () {
                const idx = nextIndex();
                const wrap = document.createElement('div');
                wrap.className = 'contact-location-block border rounded p-3 position-relative';
                wrap.innerHTML =
                    '<button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 remove-location" title="Remove" aria-label="Remove location">&times;</button>' +
                    '<div class="mb-2"><label class="form-label small text-muted mb-0">Title</label>' +
                    '<input type="text" name="contact_locations[' + idx + '][title]" class="form-control" value=""></div>' +
                    '<div class="mb-2"><label class="form-label small text-muted mb-0">Description</label>' +
                    '<textarea name="contact_locations[' + idx + '][description]" class="form-control" rows="2"></textarea></div>' +
                    '<div class="mb-0"><label class="form-label small text-muted mb-0">Map iframe (embed HTML)</label>' +
                    '<textarea name="contact_locations[' + idx + '][map_iframe]" class="form-control font-monospace small" rows="3"></textarea></div>';
                container.appendChild(wrap);
                bindRemove(wrap);
            });
        })();
    </script>
@endpush
