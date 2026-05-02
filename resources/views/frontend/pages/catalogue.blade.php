@extends('frontend.layouts.app')

@php
    $breadcrumbCrumbs = [['label' => 'Home', 'url' => route('home')]];
    if ($selectedCatalogueCategory) {
        $breadcrumbCrumbs[] = ['label' => 'Catalogue', 'url' => route('catalogue')];
        $breadcrumbCrumbs[] = ['label' => $selectedCatalogueCategory->name, 'url' => null];
    } else {
        $breadcrumbCrumbs[] = ['label' => 'Catalogue', 'url' => null];
    }
    $heroTitle = $selectedCatalogueCategory ? $selectedCatalogueCategory->name : 'Catalogue';
@endphp

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => strtoupper($heroTitle),
        'subtitle' =>
            $selectedCatalogueCategory
                ? 'Browse PDF catalogues in this category — tap a cover and share your details to download.'
                : 'Browse product catalogues — tap a cover and share your details to download the PDF.',
        'image' => asset('images/nproduct.jpeg'),
        'crumbs' => $breadcrumbCrumbs,
    ])

    @include('frontend.components.catalogue.catalogue-filters', [
        'catalogueCategories' => $catalogueCategories,
        'activeSlug' => $selectedCatalogueCategory?->slug,
    ])

    <section class="catalogue-page-main py-4 py-lg-5 bg-white">
        <div class="container">
            @include('frontend.components.catalogue.catalogue-grid', [
                'catalogues' => $catalogues,
            ])
        </div>
    </section>

    @include('frontend.components.catalogue.catalogue-download-modal')

    @include('frontend.components.home.sticky-enquiry')
@endsection

@push('scripts')
    <script>
        (function() {
            var modalEl = document.getElementById('catalogueDownloadModal');
            var form = document.getElementById('catalogueDownloadForm');
            if (!modalEl || !form) return;

            var hiddenId = document.getElementById('catalogueDownloadCatalogueId');
            var labelEl = document.getElementById('catalogueDownloadCatalogueLabel');
            var errBox = document.getElementById('catalogueDownloadFormError');
            var submitBtn = document.getElementById('catalogueDownloadSubmit');
            var modal = window.bootstrap ? new bootstrap.Modal(modalEl) : null;

            function clearErrors() {
                if (errBox) {
                    errBox.classList.add('d-none');
                    errBox.textContent = '';
                }
                form.querySelectorAll('.is-invalid').forEach(function(el) {
                    el.classList.remove('is-invalid');
                });
            }

            function showErrors(json) {
                var msg = json.message || 'Something went wrong. Please try again.';
                if (json.errors && typeof json.errors === 'object') {
                    var parts = [];
                    Object.keys(json.errors).forEach(function(k) {
                        (json.errors[k] || []).forEach(function(line) {
                            parts.push(line);
                        });
                    });
                    if (parts.length) msg = parts.join(' ');
                }
                if (errBox) {
                    errBox.textContent = msg;
                    errBox.classList.remove('d-none');
                }
            }

            document.querySelectorAll('.catalogue-book-card--pdf').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    clearErrors();
                    form.reset();
                    if (hiddenId) hiddenId.value = btn.getAttribute('data-catalogue-id') || '';
                    if (labelEl) {
                        var n = btn.getAttribute('data-catalogue-name') || '';
                        labelEl.textContent = n ? '“' + n + '”' : '';
                    }
                    if (modal) modal.show();
                });
            });

            modalEl.addEventListener('hidden.bs.modal', function() {
                clearErrors();
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                clearErrors();
                if (submitBtn) {
                    submitBtn.disabled = true;
                }

                var fd = new FormData(form);
                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: fd,
                        credentials: 'same-origin'
                    })
                    .then(function(res) {
                        return res.text().then(function(text) {
                            var data = {};
                            try {
                                data = text ? JSON.parse(text) : {};
                            } catch (ignore) {
                                data = {
                                    message: 'Unexpected response from server.'
                                };
                            }
                            return {
                                ok: res.ok,
                                status: res.status,
                                data: data
                            };
                        });
                    })
                    .then(function(result) {
                        if (result.ok && result.data && result.data.ok && result.data.pdf_url) {
                            if (modal) modal.hide();
                            window.open(result.data.pdf_url, '_blank', 'noopener,noreferrer');
                            return;
                        }
                        showErrors(result.data || {});
                    })
                    .catch(function() {
                        showErrors({
                            message: 'Network error. Please try again.'
                        });
                    })
                    .finally(function() {
                        if (submitBtn) submitBtn.disabled = false;
                    });
            });
        })();
    </script>
@endpush

