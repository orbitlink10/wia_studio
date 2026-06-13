@extends('layouts.app')

@section('title', 'Admin | WIA Studio')

@section('content')
<section class="admin">
    <div class="admin-topbar">
        <div>
            <p class="eyebrow">Backend</p>
            <h1>WIA Studio dashboard</h1>
        </div>
        <form method="post" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    @if (session('status')) <p class="notice">{{ session('status') }}</p> @endif
    @if ($errors->any()) <p class="notice error">{{ $errors->first() }}</p> @endif

    <div class="admin-metrics">
        <div><strong>{{ $projects->count() }}</strong><span>Projects</span></div>
        <div><strong>{{ $newsPosts->count() }}</strong><span>News posts</span></div>
        <div><strong>{{ $services->count() }}</strong><span>Services</span></div>
        <div><strong>{{ $inquiries->count() }}</strong><span>Recent inquiries</span></div>
    </div>

    <h2>About WIA Studio</h2>
    <details class="admin-editor" open>
        <summary>
            <span>Company profile and vision</span>
            <small>About page content</small>
        </summary>
        <form method="post" action="{{ route('admin.studio-profile.update') }}">
            @csrf
            @method('PATCH')
            <label>Company explanation<textarea name="intro" rows="3" required>{{ old('intro', $studioProfile->intro) }}</textarea></label>
            <label>Company story<textarea name="body" rows="4" required>{{ old('body', $studioProfile->body) }}</textarea></label>
            <label>Vision<textarea name="vision" rows="3" required>{{ old('vision', $studioProfile->vision) }}</textarea></label>
            <div class="admin-form-grid source-grid">
                <label>About image URL 1<input name="image_one" value="{{ old('image_one', $studioProfile->image_one) }}" placeholder="https://..."></label>
                <label>About image URL 2<input name="image_two" value="{{ old('image_two', $studioProfile->image_two) }}" placeholder="https://..."></label>
            </div>
            <div class="admin-form-grid source-grid">
                <label>Contact email<input type="email" name="contact_email" value="{{ old('contact_email', $studioProfile->contact_email) }}" placeholder="studio@wia.com" required></label>
                <label>Phone number<input name="phone_number" value="{{ old('phone_number', $studioProfile->phone_number) }}" placeholder="+254 ..." required></label>
            </div>
            <div class="admin-form-grid about-grid-admin">
                <label>Architecture<textarea name="architecture_text" rows="3" required>{{ old('architecture_text', $studioProfile->architecture_text) }}</textarea></label>
                <label>Interiors<textarea name="interiors_text" rows="3" required>{{ old('interiors_text', $studioProfile->interiors_text) }}</textarea></label>
                <label>Landscape<textarea name="landscape_text" rows="3" required>{{ old('landscape_text', $studioProfile->landscape_text) }}</textarea></label>
                <label>Planning<textarea name="planning_text" rows="3" required>{{ old('planning_text', $studioProfile->planning_text) }}</textarea></label>
                <label>Products<textarea name="products_text" rows="3" required>{{ old('products_text', $studioProfile->products_text) }}</textarea></label>
            </div>
            <button type="submit">Save about content</button>
        </form>
    </details>

    <h2>Add news, event, award, or lecture</h2>
    <details class="admin-editor" open>
        <summary>
            <span>New client-facing update</span>
            <small>Select news, event, award, or lecture</small>
        </summary>
        <form method="post" action="{{ route('admin.news.store') }}">
            @csrf
            <div class="admin-form-grid news-grid">
                <label>Title<input name="title" value="{{ old('title') }}" required></label>
                <label>Category
                    <select name="category" required>
                        @foreach (['news', 'events', 'awards', 'lectures'] as $category)
                            <option value="{{ $category }}" @selected(old('category') === $category)>{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Date<input type="date" name="published_at" value="{{ old('published_at', now()->format('Y-m-d')) }}"></label>
                <label>Image URL<input name="image_url" value="{{ old('image_url') }}" placeholder="https://..."></label>
            </div>
            <label>News text<textarea name="body" rows="5" required>{{ old('body') }}</textarea></label>
            <div class="admin-form-grid source-grid">
                <label>Source label<input name="source_label" value="{{ old('source_label') }}" placeholder="aia.org"></label>
                <label>Source URL<input name="source_url" value="{{ old('source_url') }}" placeholder="https://..."></label>
            </div>
            <label class="admin-check">
                <input type="checkbox" name="published" value="1" checked>
                <span>Published for clients</span>
            </label>
            <button type="submit">Publish update</button>
        </form>
    </details>

    <h2>News, events, awards, and lectures</h2>
    <div class="admin-editor-list compact">
        @forelse ($newsPosts as $post)
            <details class="admin-editor">
                <summary>
                    <span>{{ $post->title }}</span>
                    <small>{{ ucfirst($post->category) }} / {{ $post->published ? 'Published' : 'Hidden' }}</small>
                </summary>
                <form method="post" action="{{ route('admin.news.update', $post) }}">
                    @csrf
                    @method('PATCH')
                    <div class="admin-form-grid news-grid">
                        <label>Title<input name="title" value="{{ old('title', $post->title) }}" required></label>
                        <label>Category
                            <select name="category" required>
                                @foreach (['news', 'events', 'awards', 'lectures'] as $category)
                                    <option value="{{ $category }}" @selected(old('category', $post->category) === $category)>{{ ucfirst($category) }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>Date<input type="date" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d')) }}"></label>
                        <label>Image URL<input name="image_url" value="{{ old('image_url', $post->image_url) }}"></label>
                    </div>
                    <label>News text<textarea name="body" rows="4" required>{{ old('body', $post->body) }}</textarea></label>
                    <div class="admin-form-grid source-grid">
                        <label>Source label<input name="source_label" value="{{ old('source_label', $post->source_label) }}"></label>
                        <label>Source URL<input name="source_url" value="{{ old('source_url', $post->source_url) }}"></label>
                    </div>
                    <label class="admin-check">
                        <input type="checkbox" name="published" value="1" @checked(old('published', $post->published))>
                        <span>Published for clients</span>
                    </label>
                    <button type="submit">Save news</button>
                </form>
            </details>
        @empty
            <p class="notice">No news posts yet.</p>
        @endforelse
    </div>

    <h2>Add new project</h2>
    <details class="admin-editor" open>
        <summary>
            <span>New project</span>
            <small>Manual company entry</small>
        </summary>
        <form method="post" action="{{ route('admin.projects.store') }}">
            @csrf
            <div class="admin-form-grid">
                <label>Title<input name="title" value="{{ old('title') }}" required></label>
                <label>Slug<input name="slug" value="{{ old('slug') }}" placeholder="Auto-created if empty"></label>
                <label>Location<input name="location" value="{{ old('location') }}" required></label>
                <label>Year<input name="year" value="{{ old('year', date('Y')) }}" required></label>
                <label>Client<input name="client" value="{{ old('client') }}" required></label>
                <label>Typology<input name="typology" value="{{ old('typology') }}" placeholder="Architecture, Interiors, Landscape..." required></label>
                <label>Size<input name="size" value="{{ old('size') }}" placeholder="m2 / ft2" required></label>
                <label>Status<input name="status" value="{{ old('status') }}" placeholder="Completed, In design..." required></label>
            </div>
            <label>Hero image URL<input name="hero_image" value="{{ old('hero_image') }}" placeholder="https://..." required></label>
            <label>Summary<textarea name="summary" rows="4" required>{{ old('summary') }}</textarea></label>
            <label class="admin-check">
                <input type="checkbox" name="featured" value="1" @checked(old('featured'))>
                <span>Featured on home page</span>
            </label>
            <button type="submit">Add project</button>
        </form>
    </details>

    <h2>Project properties</h2>
    <div class="admin-editor-list">
        @foreach ($projects as $project)
            <details class="admin-editor" @if ($loop->first) open @endif>
                <summary>
                    <span>{{ $project->title }}</span>
                    <small>{{ $project->typology }} / {{ $project->status }}</small>
                </summary>
                <div class="admin-project-preview">
                    <div class="admin-project-preview-info">
                        <span class="pl-mark"><img src="/assets/img/wia-logo.svg" alt=""></span>
                        <h3>{{ $project->title }}</h3>
                        <p>{{ $project->location }}</p>
                        <small>{{ $project->typology }}</small>
                    </div>
                    <figure class="admin-project-preview-image">
                        <img src="{{ $project->hero_image }}" alt="{{ $project->title }}">
                    </figure>
                </div>
                <form method="post" action="{{ route('admin.projects.update', $project) }}">
                    @csrf
                    @method('PATCH')
                    <div class="admin-form-grid">
                        <label>Title<input name="title" value="{{ old('title', $project->title) }}" required></label>
                        <label>Slug<input name="slug" value="{{ old('slug', $project->slug) }}"></label>
                        <label>Location<input name="location" value="{{ old('location', $project->location) }}" required></label>
                        <label>Year<input name="year" value="{{ old('year', $project->year) }}" required></label>
                        <label>Client<input name="client" value="{{ old('client', $project->client) }}" required></label>
                        <label>Typology<input name="typology" value="{{ old('typology', $project->typology) }}" required></label>
                        <label>Size<input name="size" value="{{ old('size', $project->size) }}" required></label>
                        <label>Status<input name="status" value="{{ old('status', $project->status) }}" required></label>
                    </div>
                    <label>Hero image URL<input name="hero_image" value="{{ old('hero_image', $project->hero_image) }}" required></label>
                    <label>Summary<textarea name="summary" rows="4" required>{{ old('summary', $project->summary) }}</textarea></label>
                    <label class="admin-check">
                        <input type="checkbox" name="featured" value="1" @checked(old('featured', $project->featured))>
                        <span>Featured on home page</span>
                    </label>
                    <button type="submit">Save project</button>
                </form>
                <div class="admin-chapter-manager">
                    <div class="admin-chapter-head">
                        <h3>Project plans and details</h3>
                        <p>Add the extra image panels and explanations that clients see when they open this project.</p>
                    </div>

                    <div class="admin-slide-strip" aria-label="{{ $project->title }} horizontal client slides">
                        <article class="admin-slide-panel admin-slide-hero">
                            <img src="{{ $project->hero_image }}" alt="{{ $project->title }}">
                            <span>Hero image</span>
                        </article>
                        <article class="admin-slide-panel admin-slide-copy">
                            <span>Overview</span>
                            <h4>{{ $project->title }}</h4>
                            <p>{{ $project->summary }}</p>
                        </article>
                        @foreach ($project->chapters as $chapter)
                            <article class="admin-slide-panel admin-slide-plan">
                                <figure><img src="{{ $chapter->image }}" alt="{{ $chapter->label }}"></figure>
                                <div>
                                    <span>{{ str_pad($chapter->position, 2, '0', STR_PAD_LEFT) }}</span>
                                    <h4>{{ $chapter->label }}</h4>
                                    <p>{{ $chapter->body }}</p>
                                </div>
                            </article>
                        @endforeach
                        <a class="admin-slide-panel admin-slide-empty" href="#add-plan-{{ $project->id }}">
                            <span>+</span>
                            <h4>Empty next slide</h4>
                            <p>Add a plan image and explanation to create another horizontal client panel.</p>
                        </a>
                    </div>

                    <details class="admin-sub-editor" id="add-plan-{{ $project->id }}" open>
                        <summary>
                            <span>Add new plan/detail</span>
                            <small>{{ $project->chapters->count() }} saved</small>
                        </summary>
                        <form method="post" action="{{ route('admin.project-chapters.store', $project) }}">
                            @csrf
                            <div class="admin-form-grid chapter-grid">
                                <label>Order<input type="number" name="position" min="1" max="99" value="{{ old('position', $project->chapters->max('position') + 1 ?: 1) }}" required></label>
                                <label>Title<input name="label" value="{{ old('label') }}" placeholder="Plan, courtyard, material study..." required></label>
                                <label>Image URL<input name="image" value="{{ old('image') }}" placeholder="https://..." required></label>
                            </div>
                            <label>Explanation<textarea name="body" rows="3" required>{{ old('body') }}</textarea></label>
                            <button type="submit">Add plan</button>
                        </form>
                    </details>

                    @foreach ($project->chapters as $chapter)
                        <details class="admin-sub-editor">
                            <summary>
                                <span>{{ str_pad($chapter->position, 2, '0', STR_PAD_LEFT) }} / {{ $chapter->label }}</span>
                                <small>Editable client detail</small>
                            </summary>
                            <form method="post" action="{{ route('admin.project-chapters.update', $chapter) }}">
                                @csrf
                                @method('PATCH')
                                <div class="admin-form-grid chapter-grid">
                                    <label>Order<input type="number" name="position" min="1" max="99" value="{{ old('position', $chapter->position) }}" required></label>
                                    <label>Title<input name="label" value="{{ old('label', $chapter->label) }}" required></label>
                                    <label>Image URL<input name="image" value="{{ old('image', $chapter->image) }}" required></label>
                                </div>
                                <label>Explanation<textarea name="body" rows="3" required>{{ old('body', $chapter->body) }}</textarea></label>
                                <button type="submit">Save plan</button>
                            </form>
                        </details>
                    @endforeach
                </div>
            </details>
        @endforeach
    </div>

    <h2>Service cards</h2>
    <div class="admin-editor-list compact">
        @foreach ($services as $service)
            <details class="admin-editor">
                <summary>
                    <span>{{ $service->name }}</span>
                    <small>Position {{ $service->position }}</small>
                </summary>
                <form method="post" action="{{ route('admin.services.update', $service) }}">
                    @csrf
                    @method('PATCH')
                    <div class="admin-form-grid service-grid">
                        <label>Name<input name="name" value="{{ old('name', $service->name) }}" required></label>
                        <label>Position<input type="number" name="position" min="1" max="99" value="{{ old('position', $service->position) }}" required></label>
                    </div>
                    <label>Description<textarea name="description" rows="3" required>{{ old('description', $service->description) }}</textarea></label>
                    <button type="submit">Save service</button>
                </form>
            </details>
        @endforeach
    </div>

    <h2>Recent inquiries</h2>
    <div class="admin-table">
        @forelse ($inquiries as $inquiry)
            <article>
                <strong>{{ $inquiry->first_name }} {{ $inquiry->last_name }}</strong>
                <span>{{ $inquiry->email }} / {{ $inquiry->project_type }}</span>
                <p>{{ $inquiry->message }}</p>
                <small>{{ $inquiry->created_at->format('d M Y H:i') }}</small>
            </article>
        @empty
            <p>No inquiries yet. Contact form submissions will appear here.</p>
        @endforelse
    </div>
</section>
@endsection
