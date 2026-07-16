@extends('layouts.app')

@section('title', $project->title . ' | WIA Studio')
@section('body_class', 'big-white-page big-project-detail-page')

@section('content')
@php
    $imageUrl = function (?string $url, int $width = 1600): string {
        if (! $url) {
            return '';
        }

        if (str_contains($url, 'images.unsplash.com')) {
            $separator = str_contains($url, '?') ? '&' : '?';

            return $url.$separator.'auto=format&fit=crop&w='.$width.'&q=78';
        }

        return wia_media_url($url);
    };

    $chapterSlides = $project->chapters->take(5)->map(fn ($chapter) => [
        'type' => 'chapter',
        'eyebrow' => $chapter->label,
        'title' => $chapter->label,
        'body' => $chapter->body,
        'image' => $chapter->image,
    ])->values();

    if ($chapterSlides->isEmpty()) {
        $chapterSlides->push([
            'type' => 'chapter',
            'eyebrow' => 'Design Intent',
            'title' => 'Design Intent',
            'body' => $project->summary,
            'image' => $project->hero_image,
        ]);
    }

    $slides = collect([
        [
            'type' => 'hero',
            'eyebrow' => 'Project',
            'title' => $project->title,
            'body' => $project->location,
            'image' => $project->hero_image,
        ],
        [
            'type' => 'copy',
            'eyebrow' => 'Overview',
            'title' => 'Overview',
            'body' => $project->summary,
            'image' => $project->overview_image ?: $project->hero_image,
        ],
        [
            'type' => 'facts',
            'eyebrow' => 'Facts',
            'title' => 'Project Facts',
            'body' => $project->summary,
            'image' => $project->hero_image,
        ],
    ])->merge($chapterSlides);

    $supportSlides = collect([
        [
            'type' => 'copy',
            'eyebrow' => 'Spatial Strategy',
            'title' => 'Spatial Strategy',
            'body' => 'The project is presented through a consistent sequence of context, brief, spatial moves, material direction, delivery notes, and credits.',
            'image' => $project->spatial_image ?: ($project->chapters->first()?->image ?? $project->hero_image),
        ],
        [
            'type' => 'media',
            'eyebrow' => 'Material And Atmosphere',
            'title' => 'Material And Atmosphere',
            'body' => 'Images are optimized for fast loading while preserving the visual tone of the studio archive.',
            'image' => $project->material_image ?: ($project->chapters->skip(1)->first()?->image ?? $project->hero_image),
        ],
        [
            'type' => 'copy',
            'eyebrow' => 'Delivery Notes',
            'title' => 'Delivery Notes',
            'body' => $project->status.' / '.$project->size.' m2 / ft2 / '.$project->typology,
            'image' => $project->delivery_image ?: ($project->chapters->skip(2)->first()?->image ?? $project->hero_image),
        ],
        [
            'type' => 'credits',
            'eyebrow' => 'Credits',
            'title' => 'Credits',
            'body' => 'Project team and studio contact.',
            'image' => $project->hero_image,
        ],
    ]);

    $slides = $slides->merge($supportSlides->take(max(0, 8 - $slides->count())))->take(10)->values();
@endphp

<section class="big-subnav" aria-label="Project typologies">
    <a class="active" href="{{ route('projects.index') }}">Culture</a>
    <a href="{{ route('projects.index') }}">Education</a>
    <a href="{{ route('projects.index') }}">Work</a>
    <a href="{{ route('projects.index') }}">Hospitality</a>
    <a href="{{ route('projects.index') }}">Residential</a>
    <a href="{{ route('projects.index') }}">Infrastructure</a>
    <a href="{{ route('projects.index') }}">Space</a>
    <a href="{{ route('projects.index') }}">Sports</a>
    <a href="{{ route('projects.index') }}">Health</a>
</section>

<section class="big-project-wide project-slide-deck" aria-label="{{ $project->title }} slide deck">
    <aside class="big-project-sidebar">
        <span class="big-project-icon"><img src="{{ asset('assets/img/wia-logo-white.svg') }}" alt=""></span>
        <h1>{{ $project->title }}</h1>
        <p class="project-place">{{ $project->location }}</p>

        <dl>
            <dt>Year</dt><dd>{{ $project->year }}</dd>
            <dt>Client</dt><dd>{{ $project->client }}</dd>
            <dt>Typology</dt><dd>{{ $project->typology }}</dd>
            <dt>Size m2/ft2</dt><dd>{{ $project->size }}</dd>
            <dt>Status</dt><dd>{{ $project->status }}</dd>
        </dl>

        <div class="big-share">
            <span>Share</span>
            <button type="button" data-share>Email</button>
            <button type="button" data-print>Print</button>
            <a href="{{ route('projects.factsheet', $project) }}">Factsheet</a>
        </div>

        <div class="project-slide-controls" aria-label="Slide controls">
            <button type="button" data-slide-prev aria-label="Previous slide">Prev</button>
            <button type="button" data-slide-next aria-label="Next slide">Next</button>
        </div>
    </aside>

    <div class="big-wide-track" data-project-slide-track tabindex="0">
        @foreach ($slides as $slide)
            <section class="project-slide project-slide-{{ $slide['type'] }}" aria-label="{{ $slide['eyebrow'] }} {{ $slide['title'] }}">
                @if (in_array($slide['type'], ['hero', 'media'], true))
                    <figure class="wide-media">
                        <img
                            src="{{ $imageUrl($slide['image'], $loop->first ? 1800 : 1400) }}"
                            alt="{{ $slide['title'] }}"
                            loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                            decoding="async"
                        >
                    </figure>
                    <article class="wide-copy small">
                        <span>{{ $slide['eyebrow'] }}</span>
                        <h2>{{ $slide['title'] }}</h2>
                        <p>{{ $slide['body'] }}</p>
                    </article>
                @elseif ($slide['type'] === 'facts')
                    <article class="wide-copy project-facts-slide">
                        <span>{{ $slide['eyebrow'] }}</span>
                        <h2>{{ $slide['title'] }}</h2>
                        <dl>
                            <dt>Year</dt><dd>{{ $project->year }}</dd>
                            <dt>Client</dt><dd>{{ $project->client }}</dd>
                            <dt>Typology</dt><dd>{{ $project->typology }}</dd>
                            <dt>Size</dt><dd>{{ $project->size }}</dd>
                            <dt>Status</dt><dd>{{ $project->status }}</dd>
                            <dt>URL</dt><dd>{{ route('projects.show', $project) }}</dd>
                        </dl>
                    </article>
                @elseif ($slide['type'] === 'credits')
                    <article class="wide-credits">
                        <span>{{ $slide['eyebrow'] }}</span>
                        <h2>{{ $slide['title'] }}</h2>
                        @foreach ($project->credits as $credit)
                            <p><strong>{{ $credit->role }}</strong>{{ $credit->name }}</p>
                        @endforeach
                        <p><strong>Contact</strong>{{ $siteProfile->contact_email ?? 'studio@wia.com' }} / {{ $siteProfile->phone_number ?? '+254 700 000 000' }}</p>
                    </article>
                @else
                    <figure class="wide-media">
                        <img
                            src="{{ $imageUrl($slide['image'], 1400) }}"
                            alt="{{ $slide['title'] }}"
                            loading="lazy"
                            decoding="async"
                        >
                    </figure>
                    <article class="wide-copy small">
                        <span>{{ $slide['eyebrow'] }}</span>
                        <h2>{{ $slide['title'] }}</h2>
                        <p>{{ $slide['body'] }}</p>
                    </article>
                @endif
            </section>
        @endforeach
    </div>
</section>

<section class="big-next-list">
    @foreach ($moreProjects as $item)
        <a class="big-project-row" href="{{ route('projects.show', $item) }}">
            <div class="big-project-info">
                <span class="big-project-icon"><img src="{{ asset('assets/img/wia-logo-white.svg') }}" alt=""></span>
                <h2>{{ $item->title }}</h2>
                <p>{{ $item->location }}</p>
            </div>
            <img class="big-project-image" src="{{ wia_media_url($item->hero_image) }}" alt="{{ $item->title }}">
        </a>
    @endforeach
</section>
@endsection
