@extends('layouts.app')

@section('title', $project->title . ' | WIA Studio')
@section('body_class', 'big-white-page big-project-detail-page')

@section('content')
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

<section class="big-project-wide">
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
    </aside>

    <div class="big-wide-track">
        <figure class="wide-media wide-hero">
            <img src="{{ $project->hero_image }}" alt="{{ $project->title }}">
        </figure>

        <article class="wide-copy">
            <p>{{ $project->summary }}</p>
        </article>

        @foreach ($project->chapters as $chapter)
            <figure class="wide-media">
                <img src="{{ $chapter->image }}" alt="{{ $chapter->label }}">
            </figure>
            <article class="wide-copy small">
                <span>{{ str_pad($chapter->position, 2, '0', STR_PAD_LEFT) }} / {{ $chapter->label }}</span>
                <p>{{ $chapter->body }}</p>
            </article>
        @endforeach

        <article class="wide-credits">
            <span>Project Credits</span>
            @foreach ($project->credits as $credit)
                <p><strong>{{ $credit->role }}</strong>{{ $credit->name }}</p>
            @endforeach
            <p><strong>Contact</strong>{{ $siteProfile->contact_email ?? 'studio@wia.com' }} / {{ $siteProfile->phone_number ?? '+254 700 000 000' }}</p>
        </article>
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
            <img class="big-project-image" src="{{ $item->hero_image }}" alt="{{ $item->title }}">
        </a>
    @endforeach
</section>
@endsection
