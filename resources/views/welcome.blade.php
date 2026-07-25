@extends('layouts.app')

@section('title', 'WIA Studio | Projects')

@section('content')
<section class="big-index" id="projects">
    @include('partials.category-panel')

    <div class="big-project-list">
        @foreach ($projects as $project)
            <a class="big-project-row" href="{{ route('projects.show', $project) }}">
                <div class="big-project-info">
                    <span class="big-project-icon"><img src="{{ asset('assets/img/wia-logo.svg') }}" alt=""></span>
                    <h2>{{ $project->title }}</h2>
                    <p>{{ $project->location }}</p>
                </div>
                <img class="big-project-image" src="{{ wia_media_url($project->hero_image) }}" alt="{{ $project->title }}" width="1600" height="900">
            </a>
        @endforeach
    </div>
</section>

<section class="big-info-band" id="studio">
    <div>
        <p>WIA Studio</p>
        <h1>Architecture / Design / Build</h1>
    </div>
    <div>
        <p>We pair architectural rigor with the realities of building in East Africa: climate, approvals, budget, craft, maintenance, and the daily rituals that make a space work.</p>
    </div>
</section>

<section class="brand-system" id="identity">
    <div class="brand-system-main">
        <img src="{{ asset('assets/img/wia-logo.svg') }}" alt="WIA Studio logo">
        <div>
            <p class="eyebrow">Identity</p>
            <h2>WIA Studio</h2>
            <p>Architecture / Design / Build</p>
            <a href="{{ asset('assets/img/wia-logo.svg') }}" download>Download editable SVG logo</a>
        </div>
    </div>
    <div class="brand-system-cards">
        <article><span>01</span><strong>Balance</strong><p>Architecture that holds proportion, light, and structure together.</p></article>
        <article><span>02</span><strong>Design</strong><p>Clear concepts, disciplined material choices, and human-scale detail.</p></article>
        <article><span>03</span><strong>Build</strong><p>Documentation and delivery thinking from the first sketch.</p></article>
    </div>
</section>

<section class="section compact" id="services">
    <div class="section-head">
        <p class="eyebrow">Services</p>
        <h2>Project resources.</h2>
    </div>
    <div class="service-grid">
        @foreach ($services as $service)
            <article class="service-card">
                <span>{{ str_pad($service->position, 2, '0', STR_PAD_LEFT) }}</span>
                <h3>{{ $service->name }}</h3>
                <p>{{ $service->description }}</p>
            </article>
        @endforeach
    </div>
</section>

<section class="contact" id="contact">
    <div>
        <p class="eyebrow">Contact</p>
        <h2>Let's build something remarkable.</h2>
        <p>Send a project brief, request a feasibility study, or ask for a studio introduction.</p>
        <dl>
            <dt>Email</dt><dd><a href="mailto:{{ $studioProfile->contact_email ?: 'studio@wia.com' }}">{{ $studioProfile->contact_email ?: 'studio@wia.com' }}</a></dd>
            <dt>Phone</dt><dd><a href="tel:{{ preg_replace('/[^0-9+]/', '', $studioProfile->phone_number ?: '+254700000000') }}">{{ $studioProfile->phone_number ?: '+254 700 000 000' }}</a></dd>
            <dt>Studio</dt><dd>Nairobi, Kenya</dd>
            <dt>Hours</dt><dd>Monday to Friday, 8am to 6pm</dd>
        </dl>
    </div>
    <form method="post" action="{{ route('contact.store') }}">
        @csrf
        @if (session('status')) <p class="notice">{{ session('status') }}</p> @endif
        @if ($errors->any()) <p class="notice error">{{ $errors->first() }}</p> @endif
        <div class="form-row">
            <label>First name<input name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" required></label>
            <label>Last name<input name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" required></label>
        </div>
        <label>Email address<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required></label>
        <label>Project type
            <select name="project_type" required>
                <option value="">Select a service</option>
                @foreach ($services as $service)<option @selected(old('project_type') === $service->name)>{{ $service->name }}</option>@endforeach
                <option @selected(old('project_type') === 'Other')>Other</option>
            </select>
        </label>
        <label>Message<textarea name="message" rows="6" required>{{ old('message') }}</textarea></label>
        <button type="submit">Send message</button>
    </form>
</section>
@endsection
