<?php

/**
 * Frontend SEO for routes that do not override via Blade @section('seo_*').
 * Edit title, description, and keywords here only.
 *
 * Placeholders (replaced automatically when present in the view):
 *   {category}            — product-category.show
 *   {application}       — gallery.application.show
 *   {catalogueCategory} — catalogue-category.show
 *
 * Product detail (product.show) and CMS pages (pages.show) use admin fields via @section in their views.
 */
return [
    'defaults' => [
        'title' => 'Nivoc — Strength You Can Build On',
        'description' => 'Nivoc supplies wall and ceiling systems—gypsum ceiling tiles, T-grid, soffit and fluted panels—for dealers, contractors and commercial and residential projects across India.',
        'keywords' => 'Nivoc, gypsum ceiling tiles, T-grid ceiling, false ceiling, soffit panels, fluted panels, wall panels, building materials, dealer, India',
    ],

    'by_route' => [
        'home' => [
            'title' => 'Nivoc — Wall & ceiling systems for every project',
            'description' => 'Explore Nivoc gypsum ceiling tiles, T-grid systems, soffit and fluted panels—quality materials, dealer network and project support across India.',
            'keywords' => 'Nivoc, home, gypsum tiles, T-grid, soffit panels, fluted panels, ceiling solutions, dealer, India',
        ],
        'about' => [
            'title' => 'About us | Nivoc',
            'description' => 'Learn about Nivoc—our story, mission, expertise and presence across India. Trusted wall and ceiling solutions for dealers and projects.',
            'keywords' => 'Nivoc about, company profile, ceiling manufacturer, gypsum tiles, building materials India',
        ],
        'contact' => [
            'title' => 'Contact Nivoc | Nivoc',
            'description' => 'Contact Nivoc for product enquiries, dealership support, bulk pricing and project discussions. We reply within 24 hours.',
            'keywords' => 'Nivoc contact, enquiry, dealer, WhatsApp, bulk order, catalogue, India',
        ],
        'gallery' => [
            'title' => 'Gallery | Nivoc',
            'description' => 'Browse the Nivoc gallery by application—real installations and finishes for ceilings, walls and commercial spaces.',
            'keywords' => 'Nivoc gallery, installation photos, ceiling gallery, projects India',
        ],
        'gallery.application.show' => [
            'title' => '{application} gallery | Nivoc',
            'description' => 'Photos and gallery categories for {application}—explore Nivoc installations and finishes.',
            'keywords' => 'Nivoc gallery, {application}, installation photos, India',
        ],
        'products' => [
            'title' => 'Products | Nivoc',
            'description' => 'Shop Nivoc wall and ceiling products—gypsum tiles, T-grid, soffit and fluted panels—with filters and specifications for your project.',
            'keywords' => 'Nivoc products, ceiling tiles, wall panels, catalogue, buy online India',
        ],
        'product-category.show' => [
            'title' => '{category} | Nivoc',
            'description' => 'Browse {category} from Nivoc—specifications, images and enquiry options for dealers and projects.',
            'keywords' => 'Nivoc, {category}, products, ceiling, wall panels, India',
        ],
        'catalogue' => [
            'title' => 'Catalogue | Nivoc',
            'description' => 'Browse Nivoc product catalogues by category—PDFs for gypsum, T-grid, soffit, fluted panels and more.',
            'keywords' => 'Nivoc catalogue, PDF, brochure, gypsum tiles, T-grid, soffit panels, fluted panels',
        ],
        'catalogue-category.show' => [
            'title' => '{catalogueCategory} catalogue | Nivoc',
            'description' => 'Download and browse {catalogueCategory} catalogues from Nivoc.',
            'keywords' => 'Nivoc catalogue, PDF, {catalogueCategory}, brochure, building materials',
        ],
        'faq' => [
            'title' => 'FAQ — Frequently asked questions | Nivoc',
            'description' => 'Answers about Nivoc products, dealership, gypsum and T-grid ceilings, soffit and fluted panels, pricing, installation and bulk orders.',
            'keywords' => 'Nivoc FAQ, dealer, gypsum ceiling cost, T-grid, soffit panels, fluted panels, B2B pricing, India',
        ],
        'career' => [
            'title' => 'Careers — Build your future with Nivoc | Nivoc',
            'description' => 'Join Nivoc—careers in India’s interior and building materials industry. Apply online with your CV and discover why professionals choose our culture.',
            'keywords' => 'Nivoc careers, jobs, hiring, interior industry, building materials, dealer careers India',
        ],
        'gypsum-tiles' => [
            'title' => 'Gypsum ceiling tiles | Nivoc',
            'description' => 'Nivoc gypsum ceiling tiles for commercial and residential false ceilings—performance, finishes, FAQs and dealer enquiry.',
            'keywords' => 'Nivoc gypsum ceiling tiles, gypsum tile price India, false ceiling, commercial ceiling, dealer',
        ],
        'ceiling-t-grid' => [
            'title' => 'Ceiling T-grid systems | Nivoc',
            'description' => 'Nivoc T-grid suspended ceiling systems—compatibility with gypsum tiles, costs, applications and dealer support.',
            'keywords' => 'Nivoc T-grid, ceiling grid, false ceiling frame, gypsum tile grid, commercial ceiling India',
        ],
        'soffit-panels' => [
            'title' => 'Soffit panels | Nivoc',
            'description' => 'Nivoc soffit panels for exterior ceilings and canopies—weatherproof, moisture-resistant solutions for Indian conditions.',
            'keywords' => 'Nivoc soffit panels, exterior ceiling, canopy cladding, weatherproof ceiling India',
        ],
        'fluted-panels' => [
            'title' => 'Fluted wall panels | Nivoc',
            'description' => 'Nivoc fluted panels for modern interiors—linear texture, durability and easy installation for feature walls.',
            'keywords' => 'Nivoc fluted panels, wall panels, interior design, PVC fluted, feature wall India',
        ],
    ],
];
