@extends('layouts.app')

@section('title', 'About | WIA Studio')
@section('body_class', 'big-white-page about-page')

@section('content')
<section class="about-studio about-index">
    <p class="about-kicker">WIA Studio</p>
    <h1>ABOUT</h1>

    <div class="about-grid">
        <article>
            <p>{{ $studioProfile->intro }}</p>
            <p>{{ $studioProfile->body }}</p>
        </article>
        <article>
            <p>{{ $studioProfile->vision }}</p>
            <p class="about-signature">WIA Studio<br>Architecture / Design / Build</p>
        </article>
    </div>

    <div class="about-media">
        @if ($studioProfile->image_one)
            <figure><img src="{{ $studioProfile->image_one }}" alt="WIA Studio process image"></figure>
        @endif
        @if ($studioProfile->image_two)
            <figure><img src="{{ $studioProfile->image_two }}" alt="WIA Studio project image"></figure>
        @endif
    </div>

    <div class="about-practice" aria-label="WIA Studio practice areas">
        <article><span>01</span><h2>Architecture</h2><p>{{ $studioProfile->architecture_text }}</p></article>
        <article><span>02</span><h2>Interiors</h2><p>{{ $studioProfile->interiors_text }}</p></article>
        <article><span>03</span><h2>Landscape</h2><p>{{ $studioProfile->landscape_text }}</p></article>
        <article><span>04</span><h2>Planning</h2><p>{{ $studioProfile->planning_text }}</p></article>
        <article><span>05</span><h2>Products</h2><p>{{ $studioProfile->products_text }}</p></article>
    </div>
</section>
@endsection
