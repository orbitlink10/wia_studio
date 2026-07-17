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
            $previewImages = $detailImages->pad(4, $detailImages->first());
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
            <article class="pl-summary">
                <p>{{ $project->summary }}</p>
                <dl>
                    <dt>Client</dt><dd>{{ $project->client }}</dd>
                    <dt>Status</dt><dd>{{ $project->status }}</dd>
                    <dt>Size</dt><dd>{{ $project->size }}</dd>
                </dl>
            </article>
            <figure class="pl-side-img pl-side-img-a">
                <img src="{{ $previewImages->get(1) }}" alt="{{ $project->title }} detail" loading="lazy">
            </figure>
            <figure class="pl-side-img pl-side-img-b">
                <img src="{{ $previewImages->get(2) }}" alt="{{ $project->title }} project view" loading="lazy">
            </figure>
        </a>
    @endforeach

    <p class="pl-empty {{ $projects->isEmpty() ? 'visible' : '' }}" id="plEmpty">
        {{ $projects->isEmpty() ? 'No client projects have been added yet.' : 'No projects match this filter.' }}
    </p>
</section>

@endsection
