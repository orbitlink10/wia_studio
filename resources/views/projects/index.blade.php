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
            $detailCredits = $project->credits
                ->map(fn ($credit) => [
                    'role' => $credit->role,
                    'name' => $credit->name,
                ])
                ->values();
        @endphp

        <a
            class="pl-row"
            href="{{ route('projects.show', $project) }}"
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
            data-detail-credits='@json($detailCredits, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
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
                <img src="{{ wia_media_url($project->hero_image) }}" alt="{{ $project->title }}" width="1600" height="900" loading="{{ $loop->iteration < 3 ? 'eager' : 'lazy' }}">
            </figure>
        </a>
    @endforeach

    <p class="pl-empty {{ $projects->isEmpty() ? 'visible' : '' }}" id="plEmpty">
        {{ $projects->isEmpty() ? 'No client projects have been added yet.' : 'No projects match this filter.' }}
    </p>
</section>

@php
    $footerGroups = [
        'Email' => $studioProfile->footer_emails ?: 'Studio: '.($studioProfile->contact_email ?: 'studio@wia.com'),
        'Office' => $studioProfile->footer_offices ?: 'Nairobi: '.($studioProfile->phone_number ?: '+254 700 000 000'),
        'Social' => $studioProfile->footer_socials ?: "Instagram: https://instagram.com\nLinkedIn: https://linkedin.com",
        'Legal' => $studioProfile->footer_legal ?: "Privacy\nTerms",
    ];

    $footerItems = function (?string $text) {
        return collect(preg_split('/\R+/', (string) $text))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->map(function ($line) {
                [$label, $value] = str_contains($line, ':')
                    ? array_map('trim', explode(':', $line, 2))
                    : [$line, $line];
                $href = null;

                if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $href = 'mailto:'.$value;
                } elseif (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                    $href = $value;
                } elseif (preg_match('/^\+?[0-9\s().-]{7,}$/', $value)) {
                    $href = 'tel:'.preg_replace('/[^0-9+]/', '', $value);
                }

                return compact('label', 'value', 'href');
            })
            ->values();
    };
@endphp

<section class="home-contact-drawer" id="contact" aria-label="Contact information">
    @foreach ($footerGroups as $label => $lines)
        <details class="home-contact-group">
            <summary>{{ strtoupper($label) }} <span>+</span></summary>
            <div>
                @foreach ($footerItems($lines) as $item)
                    @if ($item['href'])
                        <a href="{{ $item['href'] }}" @if (str_starts_with($item['href'], 'http')) target="_blank" rel="noopener" @endif>
                            <span>{{ $item['label'] }}</span>
                            <strong>{{ $item['value'] }}</strong>
                        </a>
                    @else
                        <p><span>{{ $item['label'] }}</span></p>
                    @endif
                @endforeach
            </div>
        </details>
    @endforeach
</section>

<a
    class="whatsapp-float"
    href="https://wa.me/254716097766"
    target="_blank"
    rel="noopener"
    aria-label="Message WIA Studio on WhatsApp"
>
    <img src="{{ asset('assets/img/whatsapp-logo.jpg') }}" alt="">
</a>

@endsection
