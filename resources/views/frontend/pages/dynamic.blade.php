@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => strtoupper($page->title),
        'image' => asset('frontend/images/about-banner.jpg'),
    ])

    <section class="py-5">
        <div class="container">
            <div class="mx-auto" style="max-width: 960px;">
                @if ($page->layout === 'faq')
                    @if (!empty($page->description))
                        <div class="mb-4">{!! $page->description !!}</div>
                    @endif

                    @php
                        $faqItems = is_array($page->faq_items) ? $page->faq_items : [];
                    @endphp

                    @if (count($faqItems))
                        <div class="accordion" id="pageFaqAccordion">
                            @foreach ($faqItems as $i => $item)
                                @php
                                    $q = trim((string) ($item['question'] ?? ''));
                                    $a = trim((string) ($item['answer'] ?? ''));
                                    $itemId = 'page-faq-' . $i;
                                @endphp
                                @continue($q === '' && $a === '')

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="{{ $itemId }}-head">
                                        <button class="accordion-button {{ $i !== 0 ? 'collapsed' : '' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#{{ $itemId }}"
                                            aria-expanded="{{ $i === 0 ? 'true' : 'false' }}"
                                            aria-controls="{{ $itemId }}">
                                            {{ $q !== '' ? $q : 'Question' }}
                                        </button>
                                    </h2>
                                    <div id="{{ $itemId }}"
                                        class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                                        aria-labelledby="{{ $itemId }}-head" data-bs-parent="#pageFaqAccordion">
                                        <div class="accordion-body">
                                            {!! $a !== '' ? nl2br(e($a)) : 'No answer provided yet.' !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div>{!! $page->description !!}</div>
                @endif
            </div>
        </div>
    </section>

@include('frontend.components.home.sticky-enquiry')

@endsection
