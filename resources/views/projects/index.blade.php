@extends('layouts.app')

@section('title', 'Projects | WIA Studio')
@section('body_class', 'big-white-page wia-index-page wia-intro-active')

@section('content')
<div class="wia-splash" id="wiaSplash" aria-hidden="true">
    <span>WIA</span>
</div>

<div class="subnav" id="subnav" aria-label="Project subcategories"></div>

<div class="filter-bar" id="filterBar">
    <span>Showing</span>
    <strong id="filterLabel">All</strong>
    <a class="filter-clear" href="{{ route('projects.index') }}" data-wia-filter-clear>Clear filter x</a>
</div>

<section class="pl" id="projects">
    @foreach ($projects as $project)
        @php
            $typology = strtolower($project->typology ?? '');
            $category = 'architecture';

            if (str_contains($typology, 'interior')) {
                $category = 'interiors';
            } elseif (str_contains($typology, 'landscape') || str_contains($typology, 'garden') || str_contains($typology, 'terrace')) {
                $category = 'landscape';
            } elseif (str_contains($typology, 'planning') || str_contains($typology, 'master') || str_contains($typology, 'urban')) {
                $category = 'planning';
            } elseif (str_contains($typology, 'product') || str_contains($typology, 'furniture') || str_contains($typology, 'lighting')) {
                $category = 'products';
            }

            $sub = str($project->typology)->slug()->value();
        @endphp

        @php
            $detailImages = collect([$project->hero_image])
                ->merge($project->chapters->pluck('image'))
                ->filter()
                ->map(fn ($image) => wia_media_url($image))
                ->take(4)
                ->values();
            $detailChapters = $project->chapters
                ->map(fn ($chapter) => [
                    'label' => $chapter->label,
                    'body' => $chapter->body,
                    'image' => wia_media_url($chapter->image),
                ])
                ->values();
        @endphp

        <a
            class="pl-row"
            href="{{ route('projects.show', $project) }}"
            data-pl-expand
            data-project-url="{{ route('projects.show', $project) }}"
            data-category="{{ $category }}"
            data-sub="{{ $sub }}"
            data-sub-label="{{ $project->typology }}"
            data-title="{{ $project->title }}"
            data-location="{{ $project->location }}"
            data-client="{{ $project->client }}"
            data-typology="{{ $project->typology }}"
            data-size="{{ $project->size }}"
            data-status="{{ $project->status }}"
            data-summary="{{ $project->summary }}"
            data-overview-image="{{ wia_media_url($project->overview_image) }}"
            data-spatial-image="{{ wia_media_url($project->spatial_image) }}"
            data-material-image="{{ wia_media_url($project->material_image) }}"
            data-delivery-image="{{ wia_media_url($project->delivery_image) }}"
            data-detail-images='@json($detailImages, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
            data-detail-chapters='@json($detailChapters, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
        >
            <div class="pl-info">
                <span class="pl-mark">
                    <img src="{{ asset('assets/img/wia-logo.svg') }}" alt="">
                </span>
                <h2 class="pl-name">{{ $project->title }}</h2>
                <p class="pl-place">{{ $project->location }}</p>
                <span class="pl-tag">{{ $project->typology }}</span>
            </div>
            <div></div>
            <figure class="pl-img">
                <img src="{{ wia_media_url($project->hero_image) }}" alt="{{ $project->title }}" loading="{{ $loop->iteration < 3 ? 'eager' : 'lazy' }}">
            </figure>
        </a>
    @endforeach

    @php
        $examples = [
            ['category' => 'architecture', 'sub' => 'residential', 'label' => 'Residential', 'name' => 'Karen Ridge Residence', 'place' => 'Karen, Nairobi', 'tag' => 'Architecture - Residential', 'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=700&q=80'],
            ['category' => 'architecture', 'sub' => 'commercial', 'label' => 'Commercial', 'name' => 'Kileleshwa Mixed-Use Development', 'place' => 'Kileleshwa, Nairobi', 'tag' => 'Architecture - Commercial', 'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=700&q=80'],
            ['category' => 'architecture', 'sub' => 'education', 'label' => 'Education', 'name' => 'Limuru Learning Pavilion', 'place' => 'Limuru, Kenya', 'tag' => 'Architecture - Education', 'image' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?w=700&q=80'],
            ['category' => 'interiors', 'sub' => 'living-spaces', 'label' => 'Living Spaces', 'name' => 'Karen Dining & Living Suite', 'place' => 'Karen, Nairobi', 'tag' => 'Interiors - Living Spaces', 'image' => 'https://images.unsplash.com/photo-1600210491369-e753d80a41f3?w=700&q=80'],
            ['category' => 'interiors', 'sub' => 'offices', 'label' => 'Offices', 'name' => 'Westlands Office Fit-Out', 'place' => 'Westlands, Nairobi', 'tag' => 'Interiors - Offices', 'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=700&q=80'],
            ['category' => 'interiors', 'sub' => 'bedrooms', 'label' => 'Bedrooms', 'name' => 'Gigiri Master Bedroom', 'place' => 'Gigiri, Nairobi', 'tag' => 'Interiors - Bedrooms', 'image' => 'https://images.unsplash.com/photo-1615873968403-89e068629265?w=700&q=80'],
            ['category' => 'landscape', 'sub' => 'courtyards', 'label' => 'Courtyards', 'name' => 'Runda Courtyard Garden', 'place' => 'Runda, Nairobi', 'tag' => 'Landscape - Courtyards', 'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=700&q=80'],
            ['category' => 'landscape', 'sub' => 'parks', 'label' => 'Parks', 'name' => 'Uhuru Gardens Revitalisation', 'place' => 'Nairobi CBD, Kenya', 'tag' => 'Landscape - Parks', 'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=700&q=80'],
            ['category' => 'landscape', 'sub' => 'terraces', 'label' => 'Terraces', 'name' => 'Gigiri Rooftop Terrace', 'place' => 'Gigiri, Nairobi', 'tag' => 'Landscape - Terraces', 'image' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=700&q=80'],
            ['category' => 'planning', 'sub' => 'city', 'label' => 'City', 'name' => 'Upperhill Urban Regeneration', 'place' => 'Upperhill, Nairobi', 'tag' => 'Planning - City', 'image' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?w=700&q=80'],
            ['category' => 'planning', 'sub' => 'region', 'label' => 'Region', 'name' => 'Naivasha Lakeside Development', 'place' => 'Naivasha, Kenya', 'tag' => 'Planning - Region', 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=700&q=80'],
            ['category' => 'planning', 'sub' => 'campus', 'label' => 'Campus', 'name' => 'Konza Technopolis Campus', 'place' => 'Machakos, Kenya', 'tag' => 'Planning - Campus', 'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=700&q=80'],
        ];

        $products = [
            ['name' => 'Drift Modular Sofa', 'place' => 'Furniture - KES 280,000', 'tag' => 'In Stock', 'sub' => 'furniture', 'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=700&q=80'],
            ['name' => 'Stellar Nebula Pendants', 'place' => 'Lighting - KES 42,000', 'tag' => 'In Stock', 'sub' => 'lighting', 'image' => 'https://images.unsplash.com/photo-1524484485831-a92ffc0de03f?w=700&q=80'],
            ['name' => 'Pivot Lounge Chair', 'place' => 'Furniture - KES 95,000', 'tag' => 'In Stock', 'sub' => 'furniture', 'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=700&q=80'],
            ['name' => 'Stone Freestanding Bath', 'place' => 'Sanitaryware - KES 480,000', 'tag' => 'Made to Order', 'sub' => 'sanitaryware', 'image' => 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=700&q=80'],
            ['name' => 'Rift Canvas Series', 'place' => 'Art & Objects - KES 38,000', 'tag' => 'In Stock', 'sub' => 'art-objects', 'image' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=700&q=80'],
            ['name' => 'Slab Dining Table', 'place' => 'Furniture - KES 165,000', 'tag' => 'Made to Order', 'sub' => 'furniture', 'image' => 'https://images.unsplash.com/photo-1538688525198-9b88f6f53126?w=700&q=80'],
            ['name' => 'Vessel Basin - Concrete', 'place' => 'Sanitaryware - KES 68,000', 'tag' => 'In Stock', 'sub' => 'sanitaryware', 'image' => 'https://images.unsplash.com/photo-1620626011761-996317702782?w=700&q=80'],
            ['name' => 'Torque Sculpture', 'place' => 'Art & Objects - KES 210,000', 'tag' => 'Enquire', 'sub' => 'art-objects', 'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=700&q=80'],
            ['name' => 'Arc Floor Lamp', 'place' => 'Lighting - KES 58,000', 'tag' => 'In Stock', 'sub' => 'lighting', 'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=700&q=80'],
            ['name' => 'Mvule Hardwood Flooring', 'place' => 'Surfaces - KES 8,500 / m2', 'tag' => 'In Stock', 'sub' => 'surfaces', 'image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=700&q=80'],
            ['name' => 'Strata Ceramic Vessel', 'place' => 'Art & Objects - KES 22,000', 'tag' => 'In Stock', 'sub' => 'art-objects', 'image' => 'https://images.unsplash.com/photo-1612198188060-c7c2a3b66eae?w=700&q=80'],
            ['name' => 'Micro-Cement Wall Panel', 'place' => 'Surfaces - KES 6,200 / m2', 'tag' => 'Made to Order', 'sub' => 'surfaces', 'image' => 'https://images.unsplash.com/photo-1615529162924-f8605388461d?w=700&q=80'],
        ];
    @endphp

    @foreach ($examples as $example)
        @php
            $exampleImages = [$example['image']];
            $exampleChapters = [[
                'label' => $example['tag'],
                'body' => 'This example highlights the scale, visual language, and delivery focus of this WIA Studio category.',
                'image' => $example['image'],
            ]];
        @endphp

        <a
            class="pl-row"
            href="#projects"
            data-pl-expand
            data-category="{{ $example['category'] }}"
            data-sub="{{ $example['sub'] }}"
            data-sub-label="{{ $example['label'] }}"
            data-title="{{ $example['name'] }}"
            data-location="{{ $example['place'] }}"
            data-client="WIA Studio"
            data-typology="{{ $example['tag'] }}"
            data-size="Concept / Reference"
            data-status="Example"
            data-summary="A reference example that shows how {{ strtolower($example['category']) }} work differs in scale, material focus, and project intent."
            data-detail-images='@json($exampleImages, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
            data-detail-chapters='@json($exampleChapters, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
        >
            <div class="pl-info">
                <span class="pl-mark">
                    <img src="{{ asset('assets/img/wia-logo.svg') }}" alt="">
                </span>
                <h2 class="pl-name">{{ $example['name'] }}</h2>
                <p class="pl-place">{{ $example['place'] }}</p>
                <span class="pl-tag">{{ $example['tag'] }}</span>
            </div>
            <div></div>
            <figure class="pl-img">
                <img src="{{ $example['image'] }}" alt="{{ $example['name'] }}" loading="lazy">
            </figure>
        </a>
    @endforeach

    @foreach ($products as $product)
        @php
            $productImages = [$product['image']];
            $productChapters = [[
                'label' => $product['tag'],
                'body' => 'This product panel shows the item scale, category, availability, and enquiry details in the same horizontal project-view format.',
                'image' => $product['image'],
            ]];
        @endphp

        <a
            class="pl-row"
            href="#projects"
            data-pl-expand
            data-category="products"
            data-sub="{{ $product['sub'] }}"
            data-sub-label="{{ str($product['sub'])->replace('-', ' ')->title() }}"
            data-title="{{ $product['name'] }}"
            data-location="{{ $product['place'] }}"
            data-client="WIA Products"
            data-typology="{{ str($product['sub'])->replace('-', ' ')->title() }}"
            data-size="Product item"
            data-status="{{ $product['tag'] }}"
            data-summary="A product example from the WIA catalogue, shown with compact item information and enquiry-ready details."
            data-detail-images='@json($productImages, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
            data-detail-chapters='@json($productChapters, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
        >
            <div class="pl-info">
                <span class="pl-mark">
                    <img src="{{ asset('assets/img/wia-logo.svg') }}" alt="">
                </span>
                <h2 class="pl-name">{{ $product['name'] }}</h2>
                <p class="pl-place">{{ $product['place'] }}</p>
                <span class="pl-tag">{{ $product['tag'] }}</span>
            </div>
            <div></div>
            <figure class="pl-img">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy">
            </figure>
        </a>
    @endforeach

    <p class="pl-empty" id="plEmpty">No projects match this filter.</p>
</section>

@endsection
