@php
    $faqAccordionId = $accordionId ?? 'faq-' . str_replace('-', '', (string) \Illuminate\Support\Str::uuid());
    $faqHeadingId = $headingId ?? $faqAccordionId . '-title';
    $faqSectionTitle = $title ?? 'Frequently asked questions';
    $faqSectionDesc = $description ?? null;
    $faqEyebrow = isset($eyebrow) ? $eyebrow : null;
    $openFirst = $openFirst ?? true;

    $rawItems = $items ?? $faqs ?? [];
    $faqItems = [];
    foreach ($rawItems as $row) {
        if (!is_array($row)) {
            continue;
        }
        $q = $row['question'] ?? $row['q'] ?? '';
        if ($q === '') {
            continue;
        }
        $faqItems[] = [
            'question' => $q,
            'answer' => $row['answer'] ?? $row['a'] ?? '',
            'html' => !empty($row['html']),
        ];
    }
@endphp

@if (count($faqItems))
    <section class="faq-section" aria-labelledby="{{ $faqHeadingId }}">
        <div class="faq-section__glow faq-section__glow--1" aria-hidden="true"></div>
        <div class="faq-section__glow faq-section__glow--2" aria-hidden="true"></div>

        <div class="container position-relative">
            <div class="faq-section__intro mx-auto text-center mb-4 mb-lg-5">
                @if (!empty($faqEyebrow))
                    <p class="faq-section__eyebrow mb-3">{{ $faqEyebrow }}</p>
                @endif
                <h2 id="{{ $faqHeadingId }}" class="faq-section__title sorath-title mb-3">
                    <span class="faq-section__title-text">{{ $faqSectionTitle }}</span>
                    <span class="faq-section__title-accent" aria-hidden="true"></span>
                </h2>
                @if (!empty($faqSectionDesc))
                    <p class="faq-section__lead mb-0 mx-auto">{{ $faqSectionDesc }}</p>
                @endif
                <div class="faq-section__rule mx-auto" aria-hidden="true"></div>
            </div>

            <div class="faq-section__list mx-auto">
                <div class="accordion faq-accordion" id="{{ $faqAccordionId }}">
                    @foreach ($faqItems as $index => $item)
                        @php
                            $collapseId = $faqAccordionId . '-c' . $index;
                            $isOpen = $openFirst && $index === 0;
                        @endphp
                        <div class="accordion-item faq-accordion__item">
                            <h3 class="accordion-header faq-accordion__header">
                                <button class="accordion-button faq-accordion__btn {{ $isOpen ? '' : 'collapsed' }}"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                    aria-expanded="{{ $isOpen ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                    <span class="faq-accordion__q-index" aria-hidden="true">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="faq-accordion__q-text">{{ $item['question'] }}</span>
                                    <span class="faq-accordion__toggle" aria-hidden="true">
                                        <i class="bi bi-plus-lg faq-accordion__icon faq-accordion__icon--plus"></i>
                                        <i class="bi bi-dash-lg faq-accordion__icon faq-accordion__icon--minus"></i>
                                    </span>
                                </button>
                            </h3>
                            <div id="{{ $collapseId }}"
                                class="accordion-collapse collapse {{ $isOpen ? 'show' : '' }}"
                                data-bs-parent="#{{ $faqAccordionId }}">
                                <div class="accordion-body faq-accordion__body">
                                    @if (!empty($item['html']))
                                        {!! $item['answer'] !!}
                                    @else
                                        {!! nl2br(e($item['answer'])) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
