@extends('layouts.app')

@section('page_title', 'Site settings')
@section('page_subtitle', 'Logo, light logo, favicon, social links, contact & footer')

@php
    $locations = old('contact_locations', $setting->contact_locations ?? []);
    if (! is_array($locations)) {
        $locations = [];
    }
    if (count($locations) === 0) {
        $locations = [['address' => '', 'call' => '', 'email' => '', 'map_iframe' => '']];
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

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">Locations (title, address, call, email, map iframe)</label>
                        <button type="button" class="adm-btn adm-btn--ghost adm-btn--sm" id="addLocationRow">
                            <i class="bi bi-plus-lg"></i> Add location
                        </button>
                    </div>

                    <div id="contactLocations" class="d-flex flex-column gap-3">
                        @foreach ($locations as $i => $loc)
                            <div class="contact-location-block border rounded p-3 position-relative">
                                <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 remove-location"
                                    title="Remove" aria-label="Remove location">&times;</button>
                                @php
                                    $titleValue = old(
                                        'contact_locations.' . $i . '.title',
                                        $loc['title'] ?? ''
                                    );
                                    $addressValue = old(
                                        'contact_locations.' . $i . '.address',
                                        $loc['address'] ?? $loc['title'] ?? $loc['description'] ?? ''
                                    );
                                    $callValue = old('contact_locations.' . $i . '.call', $loc['call'] ?? '');
                                    $emailValue = old('contact_locations.' . $i . '.email', $loc['email'] ?? '');
                                @endphp
                                <div class="mb-2">
                                    <label class="form-label small text-muted mb-0">Title</label>
                                    <input type="text" name="contact_locations[{{ $i }}][title]" class="form-control"
                                        value="{{ $titleValue }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small text-muted mb-0">Address</label>
                                    <textarea name="contact_locations[{{ $i }}][address]" class="form-control" rows="2">{{ $addressValue }}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small text-muted mb-0">Call</label>
                                    <input type="text" name="contact_locations[{{ $i }}][call]" class="form-control"
                                        value="{{ $callValue }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small text-muted mb-0">Email</label>
                                    <input type="email" name="contact_locations[{{ $i }}][email]" class="form-control"
                                        value="{{ $emailValue }}">
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small text-muted mb-0">Map iframe (embed HTML)</label>
                                    <textarea name="contact_locations[{{ $i }}][map_iframe]" class="form-control font-monospace small" rows="3"
                                        placeholder="&lt;iframe src=&quot;...&quot;&gt;&lt;/iframe&gt;">{{ old('contact_locations.'.$i.'.map_iframe', $loc['map_iframe'] ?? '') }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-4">

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h3 class="h5 mb-0">Locations preview</h3>
                        <span class="text-muted small">Shows what visitors will see</span>
                    </div>

                    <div class="row g-3" id="contactLocationsPreview">
                        @foreach ($locations as $i => $loc)
                            @php
                                $previewTitle = $loc['title'] ?? $loc['address'] ?? $loc['description'] ?? '';
                                $previewAddress = $loc['address'] ?? $loc['description'] ?? $loc['title'] ?? '';
                                $previewCall = $loc['call'] ?? '';
                                $previewEmail = $loc['email'] ?? '';
                                $previewMap = $loc['map_iframe'] ?? ($loc['map'] ?? '');
                            @endphp
                            <div class="col-md-6 col-xl-4 contact-location-preview-col">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $previewTitle !== '' ? $previewTitle : 'Location' }}</h5>

                                        <p class="card-text mb-2">
                                            <strong>Address:</strong> {{ $previewAddress !== '' ? $previewAddress : '—' }}
                                        </p>
                                        <p class="card-text mb-2">
                                            <strong>Call:</strong> {{ $previewCall !== '' ? $previewCall : '—' }}
                                        </p>
                                        <p class="card-text mb-2">
                                            <strong>Email:</strong> {{ $previewEmail !== '' ? $previewEmail : '—' }}
                                        </p>

                                        @if ($previewMap !== '')
                                            <div class="mt-3 border rounded overflow-hidden">
                                                <div class="ratio ratio-16x9 map-iframe">
                                                    {!! $previewMap !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
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

            const container = document.getElementById('contactLocations');
            const addBtn = document.getElementById('addLocationRow');
            if (!container || !addBtn) return;

            const preview = document.getElementById('contactLocationsPreview');

            function updatePreview() {
                if (!preview) return;

                const blocks = container.querySelectorAll('.contact-location-block');
                preview.innerHTML = '';

                blocks.forEach(function (block) {
                    const titleEl = block.querySelector('input[name$="[title]"]');
                    const addressEl = block.querySelector('textarea[name$="[address]"]');
                    const callEl = block.querySelector('input[name$="[call]"]');
                    const emailEl = block.querySelector('input[name$="[email]"]');
                    const mapEl = block.querySelector('textarea[name$="[map_iframe]"]');

                    const titleVal = titleEl ? titleEl.value.trim() : '';
                    const addressVal = addressEl ? addressEl.value.trim() : '';
                    const callVal = callEl ? callEl.value.trim() : '';
                    const emailVal = emailEl ? emailEl.value.trim() : '';
                    const mapVal = mapEl ? mapEl.value.trim() : '';

                    const cardTitle = titleVal !== '' ? titleVal : (addressVal !== '' ? addressVal : 'Location');

                    const mapHtml = mapVal !== ''
                        ? '<div class="mt-3 border rounded overflow-hidden"><div class="ratio ratio-16x9 map-iframe">' + mapVal + '</div></div>'
                        : '';

                    const col = document.createElement('div');
                    col.className = 'col-md-6 col-xl-4 contact-location-preview-col';
                    col.innerHTML =
                        '<div class="card shadow-sm h-100">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' + cardTitle + '</h5>' +
                        '<p class="card-text mb-2"><strong>Address:</strong> ' + (addressVal !== '' ? addressVal : '—') + '</p>' +
                        '<p class="card-text mb-2"><strong>Call:</strong> ' + (callVal !== '' ? callVal : '—') + '</p>' +
                        '<p class="card-text mb-2"><strong>Email:</strong> ' + (emailVal !== '' ? emailVal : '—') + '</p>' +
                        mapHtml +
                        '</div>' +
                        '</div>';

                    preview.appendChild(col);
                });
            }

            function nextIndex() {
                return container.querySelectorAll('.contact-location-block').length;
            }

            function bindRemove(block) {
                const btn = block.querySelector('.remove-location');
                if (btn) {
                    btn.addEventListener('click', function () {
                        if (container.querySelectorAll('.contact-location-block').length <= 1) {
                            block.querySelectorAll('input, textarea').forEach(function (el) { el.value = ''; });
                            updatePreview();
                            return;
                        }
                        block.remove();
                        updatePreview();
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
                    '<div class="mb-2"><label class="form-label small text-muted mb-0">Address</label>' +
                    '<textarea name="contact_locations[' + idx + '][address]" class="form-control" rows="2"></textarea></div>' +
                    '<div class="mb-2"><label class="form-label small text-muted mb-0">Call</label>' +
                    '<input type="text" name="contact_locations[' + idx + '][call]" class="form-control" value=""></div>' +
                    '<div class="mb-2"><label class="form-label small text-muted mb-0">Email</label>' +
                    '<input type="email" name="contact_locations[' + idx + '][email]" class="form-control" value=""></div>' +
                    '<div class="mb-0"><label class="form-label small text-muted mb-0">Map iframe (embed HTML)</label>' +
                    '<textarea name="contact_locations[' + idx + '][map_iframe]" class="form-control font-monospace small" rows="3"></textarea></div>';
                container.appendChild(wrap);
                bindRemove(wrap);
                updatePreview();
            });

            container.addEventListener('input', updatePreview);
            updatePreview();
        })();
    </script>
@endpush
