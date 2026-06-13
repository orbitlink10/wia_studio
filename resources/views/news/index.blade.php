@extends('layouts.app')

@section('title', 'News | WIA Studio')
@section('body_class', 'big-white-page news-page')

@section('content')
<section class="news-index">
    <h1>NEWS</h1>

    <div class="news-layout">
        <nav class="news-cats" aria-label="News categories">
            @foreach ($categories as $category)
                <a
                    href="{{ route('news.index', $category) }}"
                    @class(['active' => $activeCategory === $category])
                >
                    {{ strtoupper($category) }}
                </a>
            @endforeach
        </nav>

        <div class="news-list">
            @forelse ($posts as $post)
                <article class="news-item">
                    <time datetime="{{ optional($post->published_at)->format('Y-m-d') }}">
                        {{ optional($post->published_at)->format('d.m.Y') ?: $post->created_at->format('d.m.Y') }}
                    </time>

                    <figure>
                        @if ($post->image_url)
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                        @else
                            <span>WIA</span>
                        @endif
                    </figure>

                    <div class="news-copy">
                        <h2>{{ $post->title }}</h2>
                        <p>{{ $post->body }}</p>
                        @if ($post->source_url)
                            <a href="{{ $post->source_url }}" target="_blank" rel="noreferrer">
                                {{ $post->source_label ?: parse_url($post->source_url, PHP_URL_HOST) }} ↗
                            </a>
                        @elseif ($post->source_label)
                            <span>{{ $post->source_label }}</span>
                        @endif
                    </div>
                </article>
            @empty
                <p class="news-empty">No {{ $activeCategory }} posts yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
