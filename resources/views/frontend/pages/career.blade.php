@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => 'CAREERS',
        'image' => asset('images/cbre.jpeg'),
    ])

    {{-- Banner --}}
    <section class="career-hero py-5 py-lg-5">
        <div class="container">
            <div class="career-hero__inner mx-auto text-center">
                <h1 class="career-hero__title mb-3">Build Your Future with NIVOC</h1>
                <p class="career-hero__lead mb-0 mx-auto">
                    Join a fast-growing brand in India’s interior and building materials industry. At NIVOC, we don’t just create products—we build careers, leaders, and opportunities.
                </p>
            </div>
        </div>
    </section>

    {{-- Application form --}}
    <section class="career-form-section pb-5 pb-lg-5">
        <div class="container">
            <div class="career-form-shell mx-auto">
                @if (session('success'))
                    <div class="alert alert-success career-form-alert mb-4" role="alert">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger career-form-alert mb-4" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="career-form-card">
                    <h2 class="career-form-card__title text-center mb-4">Join Our Team</h2>

                    <form method="post" action="{{ route('career.store') }}" enctype="multipart/form-data" class="career-form">
                        @csrf
                        <div class="row g-3 g-lg-4">
                            <div class="col-md-4">
                                <label class="career-form__label" for="career_name">Name <span class="text-danger">*</span></label>
                                <div class="career-form__field">
                                    <i class="bi bi-person" aria-hidden="true"></i>
                                    <input type="text" name="name" id="career_name" class="career-form__input" placeholder="Full name" value="{{ old('name') }}" required autocomplete="name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="career-form__label" for="career_email">Email <span class="text-danger">*</span></label>
                                <div class="career-form__field">
                                    <i class="bi bi-envelope" aria-hidden="true"></i>
                                    <input type="email" name="email" id="career_email" class="career-form__input" placeholder="Email address" value="{{ old('email') }}" required autocomplete="email">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="career-form__label" for="career_phone">Phone <span class="text-danger">*</span></label>
                                <div class="career-form__field">
                                    <i class="bi bi-telephone" aria-hidden="true"></i>
                                    <input type="tel" name="phone" id="career_phone" class="career-form__input" placeholder="Phone number" value="{{ old('phone') }}" required autocomplete="tel">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="career-form__label" for="career_years">Years of experience <span class="text-danger">*</span></label>
                                <div class="career-form__field">
                                    <i class="bi bi-graph-up-arrow" aria-hidden="true"></i>
                                    <input type="text" name="years_experience" id="career_years" class="career-form__input" placeholder="e.g. 5 years" value="{{ old('years_experience') }}" required>
                                </div>
                                <p class="career-form__hint mb-0">Ex. 5 Years</p>
                            </div>
                            <div class="col-md-4">
                                <label class="career-form__label" for="career_education">Education <span class="text-danger">*</span></label>
                                <div class="career-form__field">
                                    <i class="bi bi-mortarboard" aria-hidden="true"></i>
                                    <input type="text" name="education" id="career_education" class="career-form__input" placeholder="Highest qualification" value="{{ old('education') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="career-form__label" for="career_position">Position <span class="text-danger">*</span></label>
                                <div class="career-form__field">
                                    <i class="bi bi-briefcase" aria-hidden="true"></i>
                                    <input type="text" name="position" id="career_position" class="career-form__input" placeholder="Role you are applying for" value="{{ old('position') }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="career-form__label" for="career_cv">Upload your CV <span class="text-danger">*</span></label>
                                <div class="career-form__file">
                                    <input type="file" name="cv" id="career_cv" class="career-form__file-input" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
                                    <label for="career_cv" class="career-form__file-label">
                                        <span class="career-form__file-btn">Choose file</span>
                                        <span class="career-form__file-name" data-career-file-name>No file chosen</span>
                                    </label>
                                </div>
                                <p class="career-form__hint mb-0">PDF, DOC or DOCX — max 5&nbsp;MB</p>
                            </div>

                            <div class="col-12">
                                <label class="career-form__label" for="career_hire">Why should we hire you? <span class="text-danger">*</span></label>
                                <div class="career-form__field career-form__field--textarea">
                                    <i class="bi bi-chat-left-text" aria-hidden="true"></i>
                                    <textarea name="hire_why" id="career_hire" class="career-form__input career-form__textarea" rows="5" placeholder="Tell us what you bring to NIVOC" required>{{ old('hire_why') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4 pt-2">
                            <button type="submit" class="career-form__submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="career-benefits py-5 py-lg-5" aria-labelledby="career-benefits-heading">
        <div class="container">
            <div class="sorath-section-header text-center mb-4 mb-lg-5 mx-auto" style="max-width: 40rem;">
                <h2 id="career-benefits-heading" class="sorath-title">Benefits</h2>
                <p class="sorath-desc mb-0">Time off, flexibility, and support so you can do your best work at NIVOC.</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-md-10 col-lg-6">
                    <div class="career-benefits-card h-100">
                        <h3 class="career-benefits-card__title">
                            <i class="bi bi-calendar-heart career-benefits-card__icon" aria-hidden="true"></i>
                            Leave benefits
                        </h3>
                        <ul class="career-benefits-list mb-0">
                            <li>Sick days</li>
                            <li>Paid holidays</li>
                            <li>Unpaid extended leave</li>
                            <li>Sabbatical</li>
                            <li>Bereavement leave</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-10 col-lg-6">
                    <div class="career-benefits-card h-100">
                        <h3 class="career-benefits-card__title">
                            <i class="bi bi-stars career-benefits-card__icon" aria-hidden="true"></i>
                            Additional benefits
                        </h3>
                        <ul class="career-benefits-list mb-0">
                            <li>Work from home</li>
                            <li>Flexible hours</li>
                            <li>Job training</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $careerCoreValues = [
            ['icon' => 'bi-shield-check', 'label' => 'Integrity'],
            ['icon' => 'bi-bullseye', 'label' => 'Customer Focus'],
            ['icon' => 'bi-people-fill', 'label' => 'Teamwork'],
            ['icon' => 'bi-arrow-clockwise', 'label' => 'Continuous Improvement'],
            ['icon' => 'bi-boxes', 'label' => 'Scalability'],
        ];

        $careerWhyBlocks = [
            [
                'title' => 'Integrity-Driven Culture',
                'body' => 'We operate with transparency, strong ethics, and a zero-politics work environment—ensuring trust at every level.',
            ],
            [
                'title' => 'Continuous Growth Mindset',
                'body' => 'From regular feedback to process improvements and skill development, we focus on evolving—individually and as a company.',
            ],
            [
                'title' => 'Structured Career Progression',
                'body' => 'As NIVOC expands across markets, we offer clearly defined growth paths with real opportunities to scale your career.',
            ],
            [
                'title' => 'Positive & Professional Work Environment',
                'body' => 'A collaborative team culture that values respect, support, and a comfortable workspace.',
            ],
            [
                'title' => 'Performance-Based Rewards',
                'body' => 'We recognize results—your contribution directly reflects in your incentives and career advancement.',
            ],
            [
                'title' => 'Tech-Enabled Work Culture',
                'body' => 'Work with modern tools, CRM systems, and streamlined processes designed for efficiency and smarter execution.',
            ],
        ];
    @endphp

    <section class="career-core-values py-4 py-lg-5" aria-labelledby="career-core-values-heading">
        <div class="container">
            <div class="sorath-section-header text-center mb-4 mb-lg-5 mx-auto" style="max-width: 36rem;">
                <h2 id="career-core-values-heading" class="sorath-title">Core Values</h2>
                <p class="sorath-desc mb-0">The principles we live by at work—how we decide, collaborate, and grow together.</p>
            </div>

            <div class="career-core-values__track">
                <ul class="career-core-values__row list-unstyled mb-0" role="list">
                    @foreach ($careerCoreValues as $cv)
                        <li class="career-core-values__item" role="listitem">
                            <div class="career-core-values__circle" aria-hidden="true">
                                <i class="bi {{ $cv['icon'] }} career-core-values__icon"></i>
                            </div>
                            <p class="career-core-values__label mb-0">{{ $cv['label'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section class="career-why py-5 py-lg-5">
        <div class="container">
            <div class="sorath-section-header text-center mb-4 mb-lg-5 mx-auto" style="max-width: 40rem;">
                <h2 class="sorath-title">Why Work With NIVOC ?</h2>
                <p class="sorath-desc mb-0">What sets our workplace apart—culture, growth, and how we support your journey.</p>
            </div>

            <div class="row g-3 g-lg-4">
                @foreach ($careerWhyBlocks as $block)
                    <div class="col-md-6 col-lg-4">
                        <article class="career-why-card h-100">
                            <h3 class="career-why-card__title">{{ $block['title'] }}</h3>
                            <p class="career-why-card__body mb-0">{{ $block['body'] }}</p>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if (!empty($careerGallerySliderCategory))
        @include('frontend.components.gallery-category-slider', [
            'galleryCategory' => $careerGallerySliderCategory,
            'sectionTitle' => 'Our Foundation ',
            'sectionSubtitle' => 'At NIVOC, our workplace is designed to inspire progress. It’s a space where teams collaborate, challenges are solved, and every individual contributes to building something bigger—together.',
            'sliderId' => 'career-page',
        ])
    @endif

    <section class="career-direct-contact py-5" aria-labelledby="career-direct-contact-heading">
        <div class="container">
            <div class="career-direct-contact__inner text-center mx-auto">
                <h2 id="career-direct-contact-heading" class="career-direct-contact__title mb-2">Want to Contact us directly?</h2>
                <p class="career-direct-contact__lead mb-1">Feel free to send a mail</p>
                <a class="career-direct-contact__email" href="mailto:hr.whiterock01@gmail.com">hr.whiterock01@gmail.com</a>
            </div>
        </div>
    </section>

    @include('frontend.components.home.sticky-enquiry')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var input = document.getElementById('career_cv');
            var label = document.querySelector('[data-career-file-name]');
            if (!input || !label) return;
            input.addEventListener('change', function () {
                var f = input.files && input.files[0];
                label.textContent = f ? f.name : 'No file chosen';
            });
        });
    </script>
@endpush
