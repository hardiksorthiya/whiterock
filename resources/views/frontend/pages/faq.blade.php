@extends('frontend.layouts.app')

@php
    $faqPageJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'Which panel is best for exterior ceiling in India?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Soffit panels are the best choice for exterior ceilings as they are weatherproof, moisture-resistant, and suitable for Indian climate conditions.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Which wall panel is best for modern interiors?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Fluted panels are widely preferred for modern interiors due to their textured design, durability, and easy installation.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'What is the cost of gypsum ceiling per sq ft?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'The cost of gypsum ceiling typically ranges between ₹60 to ₹150 per sq ft depending on material quality, grid system, and installation.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'What is the best ceiling solution for commercial spaces?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Gypsum ceiling tiles with T-Grid systems are ideal for commercial spaces due to easy maintenance, clean finish, and fast installation.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Are NIVOC panels easy to install?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes, NIVOC panels are designed for quick and hassle-free installation, saving time and labor costs.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How can I become a NIVOC dealer?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'You can apply through our website or contact our team via call or WhatsApp for dealership inquiries.',
                ],
            ],
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($faqPageJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) !!}</script>
@endpush

@section('content')
    @include('frontend.components.breadcrumb', [
        'title' => 'FAQ',
        'image' => asset('images/cbre.jpeg'),
    ])

    @include('frontend.components.block_gird')

    @include('frontend.components.faq', [
        'accordionId' => 'faq-page-main',
        'headingId' => 'faq-page-heading',
        'eyebrow' => 'FAQ',
        'title' => 'Frequently Asked Questions',
        'description' => 'Everything you need to know about NIVOC products, dealership, and project solutions.',
        'openFirst' => true,
        'items' => [
            [
                'question' => 'What products does NIVOC offer?',
                'answer' => 'NIVOC offers a wide range of wall and ceiling solutions including fluted panels, soffit panels, gypsum ceiling tiles, and T-Grid systems for residential and commercial applications.',
            ],
            [
                'question' => 'Who can partner with NIVOC?',
                'answer' => 'Dealers, distributors, contractors, architects, and builders can partner with NIVOC.',
            ],
            [
                'question' => 'How can I become a NIVOC dealer?',
                'answer' => 'You can apply through our website or contact our team via call or WhatsApp for product inquiries.',
            ],
            [
                'question' => 'Do you provide support to dealers?',
                'answer' => 'Yes, we provide product guidance, marketing support, and consistent supply to help our partners grow.',
            ],
            [
                'question' => 'Which panel is best for exterior ceiling in India?',
                'answer' => 'Soffit panels are the best choice for exterior ceilings as they are weatherproof, moisture-resistant, and suitable for Indian climate conditions.',
            ],
            [
                'question' => 'Which wall panel is best for modern interiors?',
                'answer' => 'Fluted panels are widely preferred for modern interiors due to their textured design, durability, and easy installation.',
            ],
            [
                'question' => 'What is the best ceiling solution for commercial spaces?',
                'answer' => 'Gypsum ceiling tiles with T-Grid systems are ideal for commercial spaces due to easy maintenance, clean finish, and fast installation.',
            ],
            [
                'question' => 'Are NIVOC panels easy to install?',
                'answer' => 'Yes, our panels are designed for quick and hassle-free installation, saving time and labor costs.',
            ],
            [
                'question' => 'Do you provide installation support?',
                'answer' => 'We provide guidance, installation tips, and technical assistance to ensure smooth execution.',
            ],
            [
                'question' => 'What is the price range of your products?',
                'answer' => 'Pricing varies based on product type and quantity. We offer competitive pricing with strong margins for dealers and bulk buyers.',
            ],
            [
                'question' => 'Do you handle bulk orders?',
                'answer' => 'Yes, we have a strong supply network to handle large project requirements.',
            ],
            [
                'question' => 'How can I get a catalog or price list?',
                'answer' => 'You can request it via WhatsApp or by filling out the inquiry form on our website.',
            ],
        ],
    ])

    @include('frontend.components.faq-page-cta')

    @include('frontend.components.contact', [
        'title' => 'Still Have Questions? Let’s Talk.',
        'description' => 'We’re here to help. Contact us for any questions or inquiries.',
        'eyebrow' => 'CONTACT US',
        'formNote' => 'Please include your phone number and city so we can respond with accurate logistics and pricing.',
    ])

    @include('frontend.components.home.sticky-enquiry')
@endsection
