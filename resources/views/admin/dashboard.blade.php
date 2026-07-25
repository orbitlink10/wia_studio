@extends('layouts.app')

@section('title', 'Admin | WIA Studio')

@section('content')
@php
    $projectCategories = $projectCategories ?? [
        'architecture' => 'Architecture',
        'interiors' => 'Interiors',
        'planning' => 'Planning',
        'furniture' => 'Furniture',
        'landscape' => 'Landscape',
    ];

    $categoryFromTypology = function (?string $typology) {
        $typology = strtolower($typology ?? '');

        if (str_contains($typology, 'interior')) return 'interiors';
        if (str_contains($typology, 'planning') || str_contains($typology, 'master') || str_contains($typology, 'urban')) return 'planning';
        if (str_contains($typology, 'furniture') || str_contains($typology, 'product') || str_contains($typology, 'lighting')) return 'furniture';
        if (str_contains($typology, 'landscape') || str_contains($typology, 'garden') || str_contains($typology, 'terrace')) return 'landscape';

        return 'architecture';
    };

    $typologyDetail = function (?string $typology) use ($projectCategories) {
        $detail = trim((string) $typology);

        foreach ($projectCategories as $label) {
            $detail = preg_replace('/^'.preg_quote($label, '/').'\s*-\s*/i', '', $detail);
            if (strcasecmp($detail, $label) === 0) return '';
        }

        return $detail;
    };
@endphp
@include('partials.category-panel', [
    'categoryPanelProjectUrl' => route('projects.index'),
    'categoryPanelServiceUrl' => route('projects.index'),
])

<section class="admin">
    <div class="admin-topbar">
        <div>
            <p class="eyebrow">Backend</p>
            <h1>WIA Studio dashboard</h1>
        </div>
        <div class="admin-topbar-actions">
            <a class="admin-client-link" href="{{ route('projects.index') }}" aria-label="Back to client side">
                <span aria-hidden="true">←</span>
                Client side
            </a>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    @if (session('status')) <p class="notice">{{ session('status') }}</p> @endif
    @if ($errors->any()) <p class="notice error">{{ $errors->first() }}</p> @endif

    <div class="admin-metrics">
        <div><strong>{{ $projects->count() }}</strong><span>Projects</span></div>
        <div><strong>{{ $newsPosts->count() }}</strong><span>News posts</span></div>
        <div><strong>{{ $services->count() }}</strong><span>Services</span></div>
        <div><strong>{{ $inquiries->count() }}</strong><span>Recent inquiries</span></div>
    </div>

    <h2>About and contact information</h2>
    <details class="admin-editor" open>
        <summary>
            <span>Company profile, vision, email, and phone</span>
            <small>Shown on the client side</small>
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
                <label>Footer email links<textarea name="footer_emails" rows="5" placeholder="Studio: studio@wia.com&#10;Careers: careers@wia.com">{{ old('footer_emails', $studioProfile->footer_emails) }}</textarea></label>
                <label>Footer office / call links<textarea name="footer_offices" rows="5" placeholder="Nairobi: +254 716 097 766&#10;Office: +254 700 000 000">{{ old('footer_offices', $studioProfile->footer_offices) }}</textarea></label>
                <label>Footer social links<textarea name="footer_socials" rows="5" placeholder="Instagram: https://instagram.com/...&#10;LinkedIn: https://linkedin.com/...">{{ old('footer_socials', $studioProfile->footer_socials) }}</textarea></label>
                <label>Footer legal links<textarea name="footer_legal" rows="5" placeholder="Privacy&#10;Terms">{{ old('footer_legal', $studioProfile->footer_legal) }}</textarea></label>
            </div>
            <div class="admin-form-grid about-grid-admin">
                <label>Architecture<textarea name="architecture_text" rows="3" required>{{ old('architecture_text', $studioProfile->architecture_text) }}</textarea></label>
                <label>Interiors<textarea name="interiors_text" rows="3" required>{{ old('interiors_text', $studioProfile->interiors_text) }}</textarea></label>
                <label>Landscape<textarea name="landscape_text" rows="3" required>{{ old('landscape_text', $studioProfile->landscape_text) }}</textarea></label>
                <label>Planning<textarea name="planning_text" rows="3" required>{{ old('planning_text', $studioProfile->planning_text) }}</textarea></label>
                <label>Products<textarea name="products_text" rows="3" required>{{ old('products_text', $studioProfile->products_text) }}</textarea></label>
            </div>
            <button type="submit">Save studio profile</button>
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
        <div class="admin-project-preview admin-empty-project-preview">
            <div class="admin-project-preview-info">
                <span class="pl-mark"><img src="/assets/img/wia-logo.svg" alt=""></span>
                <h3>Project title</h3>
                <p>Location</p>
                <small>Selected section</small>
            </div>
            <figure class="admin-project-preview-image">
                <span>Hero image preview</span>
            </figure>
        </div>
        <form method="post" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="admin-form-grid">
                <label>Title<input name="title" value="{{ old('title') }}" required></label>
                <label>Slug<input name="slug" value="{{ old('slug') }}" placeholder="Auto-created if empty"></label>
                <label>Location<input name="location" value="{{ old('location') }}" required></label>
                <label>Year<input name="year" value="{{ old('year', date('Y')) }}" required></label>
                <label>Client<input name="client" value="{{ old('client') }}" required></label>
                <label>Belongs to
                    <select name="category" required>
                        @foreach ($projectCategories as $value => $label)
                            <option value="{{ $value }}" @selected(old('category', 'architecture') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Type / room / product<input name="typology_detail" value="{{ old('typology_detail') }}" placeholder="Residential, sofa, campus..."></label>
                <label>Size<input name="size" value="{{ old('size') }}" placeholder="m2 / ft2" required></label>
                <label>Status<input name="status" value="{{ old('status') }}" placeholder="Completed, In design..." required></label>
            </div>
            <div class="admin-form-grid source-grid">
                <label>Upload hero image<input type="file" name="hero_image_file" accept="image/*"></label>
                <label>Or paste hero image URL<input name="hero_image" value="{{ old('hero_image') }}" placeholder="https://..."></label>
            </div>
            <div class="admin-form-grid source-grid">
                <label>Upload overview slide image<input type="file" name="overview_image_file" accept="image/*"></label>
                <label>Or paste overview image URL<input name="overview_image" value="{{ old('overview_image') }}" placeholder="Optional; uses hero image if empty"></label>
            </div>
            <label>Summary<textarea name="summary" rows="4" required>{{ old('summary') }}</textarea></label>
            <label>Architects / collaborators / credits<textarea name="collaborators" rows="8" placeholder="Architect: Name&#10;Collaborator: Name&#10;Partner in charge: Name&#10;Project manager: Name&#10;Project team: Name">{{ old('collaborators') }}</textarea></label>
            <div class="admin-form-grid chapter-grid">
                <label>Spatial strategy image<input type="file" name="spatial_image_file" accept="image/*"></label>
                <label>Material slide image<input type="file" name="material_image_file" accept="image/*"></label>
                <label>Delivery notes image<input type="file" name="delivery_image_file" accept="image/*"></label>
            </div>
            <div class="admin-form-grid chapter-grid">
                <label>Spatial image URL<input name="spatial_image" value="{{ old('spatial_image') }}" placeholder="Optional"></label>
                <label>Material image URL<input name="material_image" value="{{ old('material_image') }}" placeholder="Optional"></label>
                <label>Delivery image URL<input name="delivery_image" value="{{ old('delivery_image') }}" placeholder="Optional"></label>
            </div>
            <label class="admin-check">
                <input type="checkbox" name="featured" value="1" @checked(old('featured'))>
                <span>Featured on home page</span>
            </label>
            <button type="submit">Add project</button>
        </form>
    </details>

    <h2>Project properties</h2>
    <div class="admin-editor-list">
        @forelse ($projects as $project)
            @php
                $currentCategory = old('category', $categoryFromTypology($project->typology));
                $currentTypologyDetail = old('typology_detail', $typologyDetail($project->typology));
                $currentCollaborators = old('collaborators', $project->credits->map(fn ($credit) => $credit->role.': '.$credit->name)->implode("\n"));
            @endphp
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
                    <a class="admin-project-preview-image" href="#add-plan-{{ $project->id }}" title="Add more photos and slides">
                        <img src="{{ wia_media_url($project->hero_image) }}" alt="{{ $project->title }}" width="1600" height="900">
                        <span>Add photos / slides</span>
                    </a>
                </div>
                <form method="post" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="admin-form-grid">
                        <label>Title<input name="title" value="{{ old('title', $project->title) }}" required></label>
                        <label>Slug<input name="slug" value="{{ old('slug', $project->slug) }}"></label>
                        <label>Location<input name="location" value="{{ old('location', $project->location) }}" required></label>
                        <label>Year<input name="year" value="{{ old('year', $project->year) }}" required></label>
                        <label>Client<input name="client" value="{{ old('client', $project->client) }}" required></label>
                        <label>Belongs to
                            <select name="category" required>
                                @foreach ($projectCategories as $value => $label)
                                    <option value="{{ $value }}" @selected($currentCategory === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>Type / room / product<input name="typology_detail" value="{{ $currentTypologyDetail }}" placeholder="Residential, sofa, campus..."></label>
                        <label>Size<input name="size" value="{{ old('size', $project->size) }}" required></label>
                        <label>Status<input name="status" value="{{ old('status', $project->status) }}" required></label>
                    </div>
                    <div class="admin-form-grid source-grid">
                        <label>Replace hero image<input type="file" name="hero_image_file" accept="image/*"></label>
                        <label>Current hero image URL<input name="hero_image" value="{{ old('hero_image', $project->hero_image) }}"></label>
                    </div>
                    <div class="admin-form-grid source-grid">
                        <label>Replace overview slide image<input type="file" name="overview_image_file" accept="image/*"></label>
                        <label>Overview slide image URL<input name="overview_image" value="{{ old('overview_image', $project->overview_image) }}" placeholder="Uses hero image if empty"></label>
                    </div>
                    <label>Summary<textarea name="summary" rows="4" required>{{ old('summary', $project->summary) }}</textarea></label>
                    <label>Architects / collaborators / credits<textarea name="collaborators" rows="8" placeholder="Architect: Name&#10;Collaborator: Name&#10;Partner in charge: Name&#10;Project manager: Name&#10;Project team: Name">{{ $currentCollaborators }}</textarea></label>
                    <div class="admin-form-grid chapter-grid">
                        <label>Spatial strategy image<input type="file" name="spatial_image_file" accept="image/*"></label>
                        <label>Material slide image<input type="file" name="material_image_file" accept="image/*"></label>
                        <label>Delivery notes image<input type="file" name="delivery_image_file" accept="image/*"></label>
                    </div>
                    <div class="admin-form-grid chapter-grid">
                        <label>Spatial image URL<input name="spatial_image" value="{{ old('spatial_image', $project->spatial_image) }}" placeholder="Optional"></label>
                        <label>Material image URL<input name="material_image" value="{{ old('material_image', $project->material_image) }}" placeholder="Optional"></label>
                        <label>Delivery image URL<input name="delivery_image" value="{{ old('delivery_image', $project->delivery_image) }}" placeholder="Optional"></label>
                    </div>
                    <label class="admin-check">
                        <input type="checkbox" name="featured" value="1" @checked(old('featured', $project->featured))>
                        <span>Featured on home page</span>
                    </label>
                    <button type="submit">Save project</button>
                </form>
                <form
                    class="admin-delete-form"
                    method="post"
                    action="{{ route('admin.projects.destroy', $project) }}"
                    onsubmit="return confirm('Delete {{ addslashes($project->title) }}? This removes the project, its plans, and credits from the client side.');"
                >
                    @csrf
                    @method('DELETE')
                    <button class="admin-danger-button" type="submit">Delete project</button>
                </form>
                <div class="admin-chapter-manager">
                    @php
                        $clientSlideCount = min(10, 3 + max(1, min($project->chapters->count(), 5)));
                    @endphp
                    <div class="admin-chapter-head">
                        <h3>Project plans and details</h3>
                        <p>Each shareable project page is generated as an {{ $clientSlideCount }}-slide deck. Add up to 5 strong detail entries to keep the public presentation between 8 and 10 slides.</p>
                    </div>

                    <div class="admin-slide-strip" aria-label="{{ $project->title }} horizontal client slides">
                        <article class="admin-slide-panel admin-slide-hero">
                            <img src="{{ wia_media_url($project->hero_image) }}" alt="{{ $project->title }}" width="1600" height="900">
                            <span>Hero image</span>
                        </article>
                        <article class="admin-slide-panel admin-slide-copy">
                            <span>Overview</span>
                            <h4>{{ $project->title }}</h4>
                            <p>{{ $project->summary }}</p>
                        </article>
                        <article class="admin-slide-panel admin-slide-plan">
                            <figure><img src="{{ wia_media_url($project->overview_image ?: $project->hero_image) }}" alt="{{ $project->title }} overview" width="1600" height="900"></figure>
                            <div>
                                <span>Overview image</span>
                                <h4>Client overview slide</h4>
                                <p>{{ $project->overview_image ? 'Custom image uploaded.' : 'Using the hero image fallback.' }}</p>
                            </div>
                        </article>
                        @foreach ($project->chapters as $chapter)
                            <article class="admin-slide-panel admin-slide-plan">
                                <figure><img src="{{ wia_media_url($chapter->image) }}" alt="{{ $chapter->label }}" width="1600" height="900"></figure>
                                <div>
                                    <span>{{ str_pad($chapter->position, 2, '0', STR_PAD_LEFT) }}</span>
                                    <h4>{{ $chapter->label }}</h4>
                                    <p>{{ $chapter->body }}</p>
                                </div>
                            </article>
                        @endforeach
                        <article class="admin-slide-panel admin-slide-plan">
                            <figure><img src="{{ wia_media_url($project->spatial_image ?: ($project->chapters->first()?->image ?: $project->hero_image)) }}" alt="{{ $project->title }} spatial strategy" width="1600" height="900"></figure>
                            <div>
                                <span>Spatial strategy</span>
                                <h4>Generated client slide</h4>
                                <p>{{ $project->spatial_image ? 'Custom image uploaded.' : 'Using a project image fallback.' }}</p>
                            </div>
                        </article>
                        <article class="admin-slide-panel admin-slide-plan">
                            <figure><img src="{{ wia_media_url($project->material_image ?: ($project->chapters->skip(1)->first()?->image ?: $project->hero_image)) }}" alt="{{ $project->title }} material and atmosphere" width="1600" height="900"></figure>
                            <div>
                                <span>Material</span>
                                <h4>Generated client slide</h4>
                                <p>{{ $project->material_image ? 'Custom image uploaded.' : 'Using a project image fallback.' }}</p>
                            </div>
                        </article>
                        <article class="admin-slide-panel admin-slide-plan">
                            <figure><iframe src="https://maps.google.com/maps?q={{ urlencode($project->location) }}&amp;z=12&amp;output=embed" title="{{ $project->title }} map" loading="lazy"></iframe></figure>
                            <div>
                                <span>Location map</span>
                                <h4>{{ $project->location }}</h4>
                                <p>Interactive map panel generated from the project location.</p>
                            </div>
                        </article>
                        <article class="admin-slide-panel admin-slide-copy">
                            <span>Collaborators</span>
                            <h4>Project team</h4>
                            @forelse ($project->credits as $credit)
                                <p><strong>{{ $credit->role }}</strong> {{ $credit->name }}</p>
                            @empty
                                <p>Add collaborators in the project form to populate the final public panel.</p>
                            @endforelse
                        </article>
                        <a class="admin-slide-panel admin-slide-empty" href="#add-plan-{{ $project->id }}">
                            <span>+</span>
                            <h4>Empty next slide</h4>
                            <p>Add a plan image and explanation to create another horizontal client panel.</p>
                        </a>
                    </div>

                    <details class="admin-sub-editor" id="add-plan-{{ $project->id }}" open>
                        <summary>
                            <span>Add new plan/detail</span>
                            <small>{{ $project->chapters->count() }} saved / {{ $clientSlideCount }} public slides</small>
                        </summary>
                        <form method="post" action="{{ route('admin.project-chapters.store', $project) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="admin-form-grid chapter-grid">
                                <label>Order<input type="number" name="position" min="1" max="99" value="{{ old('position', $project->chapters->max('position') + 1 ?: 1) }}" required></label>
                                <label>Title<input name="label" value="{{ old('label') }}" placeholder="Plan, courtyard, material study..." required></label>
                                <label>Upload slide image<input type="file" name="image_file" accept="image/*"></label>
                            </div>
                            <label>Or paste slide image URL<input name="image" value="{{ old('image') }}" placeholder="https://..."></label>
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
                            <form method="post" action="{{ route('admin.project-chapters.update', $chapter) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="admin-form-grid chapter-grid">
                                    <label>Order<input type="number" name="position" min="1" max="99" value="{{ old('position', $chapter->position) }}" required></label>
                                    <label>Title<input name="label" value="{{ old('label', $chapter->label) }}" required></label>
                                    <label>Replace slide image<input type="file" name="image_file" accept="image/*"></label>
                                </div>
                                <label>Current slide image URL<input name="image" value="{{ old('image', $chapter->image) }}"></label>
                                <label>Explanation<textarea name="body" rows="3" required>{{ old('body', $chapter->body) }}</textarea></label>
                                <button type="submit">Save plan</button>
                            </form>
                        </details>
                    @endforeach
                </div>
            </details>
        @empty
            <p class="notice">No projects have been added yet. Use the form above to add the first client-facing project.</p>
        @endforelse
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
