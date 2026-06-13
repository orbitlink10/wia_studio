<?php

use App\Models\Inquiry;
use App\Models\NewsPost;
use App\Models\Project;
use App\Models\ProjectChapter;
use App\Models\Service;
use App\Models\StudioProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

Route::get('/', function () {
    return view('projects.index', [
        'projects' => Project::with(['chapters' => fn ($query) => $query->orderBy('position'), 'credits'])->latest('year')->get(),
        'services' => Service::orderBy('position')->get(),
        'studioProfile' => StudioProfile::current(),
    ]);
})->name('home');

Route::get('/projects', function () {
    return view('projects.index', [
        'projects' => Project::with(['chapters' => fn ($query) => $query->orderBy('position'), 'credits'])->latest('year')->get(),
        'services' => Service::orderBy('position')->get(),
        'studioProfile' => StudioProfile::current(),
    ]);
})->name('projects.index');

Route::get('/news/{category?}', function (?string $category = null) {
    $categories = ['news', 'events', 'awards', 'lectures'];
    $activeCategory = in_array($category, $categories, true) ? $category : 'news';

    return view('news.index', [
        'categories' => $categories,
        'activeCategory' => $activeCategory,
        'posts' => NewsPost::query()
            ->where('published', true)
            ->where('category', $activeCategory)
            ->orderByDesc('published_at')
            ->latest()
            ->get(),
    ]);
})->name('news.index');

Route::get('/about', function () {
    return view('about.index', [
        'studioProfile' => StudioProfile::current(),
    ]);
})->name('about.index');

Route::get('/contact', function () {
    return view('contact.index', [
        'studioProfile' => StudioProfile::current(),
    ]);
})->name('contact.index');

Route::get('/projects/{project:slug}', function (Project $project) {
    $project->load(['chapters' => fn ($query) => $query->orderBy('position'), 'credits']);

    return view('projects.show', [
        'project' => $project,
        'moreProjects' => Project::with(['chapters' => fn ($query) => $query->orderBy('position'), 'credits'])
            ->whereKeyNot($project->id)
            ->latest('year')
            ->get(),
    ]);
})->name('projects.show');

Route::get('/projects/{project:slug}/factsheet', function (Project $project) {
    $project->load(['chapters' => fn ($query) => $query->orderBy('position'), 'credits']);
    $studioProfile = StudioProfile::current();

    $lines = [
        'WIA STUDIO PROJECT FACTSHEET',
        '',
        'Project: '.$project->title,
        'Location: '.$project->location,
        'Year: '.$project->year,
        'Client: '.$project->client,
        'Typology: '.$project->typology,
        'Size: '.$project->size.' m2 / ft2',
        'Status: '.$project->status,
        '',
        'Summary:',
        $project->summary,
        '',
        'Chapters:',
        ...$project->chapters->map(fn ($chapter) => $chapter->position.'. '.$chapter->label.' - '.$chapter->body)->all(),
        '',
        'Credits:',
        ...$project->credits->map(fn ($credit) => $credit->role.': '.$credit->name)->all(),
        '',
        'Contact: '.$studioProfile->contact_email.' / '.$studioProfile->phone_number.' / www.wia.com',
    ];

    return response(implode(PHP_EOL, $lines), 200, [
        'Content-Type' => 'text/plain',
        'Content-Disposition' => 'attachment; filename="'.$project->slug.'-factsheet.txt"',
    ]);
})->name('projects.factsheet');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:80'],
        'last_name' => ['required', 'string', 'max:80'],
        'email' => ['required', 'email', 'max:160'],
        'project_type' => ['required', 'string', 'max:120'],
        'message' => ['required', 'string', 'max:4000'],
    ]);

    Inquiry::create($validated);

    return redirect(route('home').'#contact')->with('status', 'Message received. The studio will follow up soon.');
})->name('contact.store');

Route::get('/admin/login', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('admin.login');
})->name('admin.login');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::get('/admin/signup', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('admin.signup');
})->middleware('guest')->name('admin.signup');

Route::post('/admin/signup', function (Request $request) {
    $validated = $request->validate([
        'email' => ['required', 'email', 'max:160', 'regex:/^[A-Z0-9._%+\-]+@gmail\.com$/i', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8'],
    ], [
        'email.regex' => 'Please use an admin Gmail address ending in @gmail.com.',
    ]);

    $validated['name'] = Str::of($validated['email'])->before('@')->replace(['.', '_', '-'], ' ')->title()->value();

    $admin = User::create($validated);

    Auth::login($admin);
    $request->session()->regenerate();

    return redirect()->route('admin.dashboard')->with('status', 'Admin account created.');
})->middleware('guest')->name('admin.signup.store');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()
            ->withErrors(['email' => 'The provided credentials do not match an admin account.'])
            ->onlyInput('email');
    }

    $request->session()->regenerate();

    return redirect()->intended(route('admin.dashboard'));
})->middleware('guest')->name('admin.login.store');

Route::post('/admin/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login');
})->middleware('auth')->name('admin.logout');

Route::get('/admin', function () {
    return view('admin.dashboard', [
        'projects' => Project::with(['chapters' => fn ($query) => $query->orderBy('position')])->latest('year')->get(),
        'newsPosts' => NewsPost::orderByDesc('published_at')->latest()->get(),
        'services' => Service::orderBy('position')->get(),
        'studioProfile' => StudioProfile::current(),
        'inquiries' => Inquiry::latest()->limit(25)->get(),
    ]);
})->middleware('auth')->name('admin.dashboard');

Route::patch('/admin/studio-profile', function (Request $request) {
    $validated = $request->validate([
        'intro' => ['required', 'string', 'max:2000'],
        'body' => ['required', 'string', 'max:5000'],
        'vision' => ['required', 'string', 'max:3000'],
        'image_one' => ['nullable', 'string', 'max:500'],
        'image_two' => ['nullable', 'string', 'max:500'],
        'contact_email' => ['required', 'email', 'max:160'],
        'phone_number' => ['required', 'string', 'max:80'],
        'architecture_text' => ['required', 'string', 'max:2000'],
        'interiors_text' => ['required', 'string', 'max:2000'],
        'landscape_text' => ['required', 'string', 'max:2000'],
        'planning_text' => ['required', 'string', 'max:2000'],
        'products_text' => ['required', 'string', 'max:2000'],
    ]);

    StudioProfile::current()->update($validated);

    return redirect()->route('admin.dashboard')->with('status', 'About page content updated.');
})->middleware('auth')->name('admin.studio-profile.update');

Route::post('/admin/news', function (Request $request) {
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:220'],
        'category' => ['required', Rule::in(['news', 'events', 'awards', 'lectures'])],
        'published_at' => ['nullable', 'date'],
        'image_url' => ['nullable', 'string', 'max:500'],
        'body' => ['required', 'string', 'max:8000'],
        'source_label' => ['nullable', 'string', 'max:120'],
        'source_url' => ['nullable', 'string', 'max:500'],
    ]);

    $validated['published'] = $request->boolean('published', true);

    NewsPost::create($validated);

    return redirect()->route('admin.dashboard')->with('status', 'News post added.');
})->middleware('auth')->name('admin.news.store');

Route::patch('/admin/news/{newsPost}', function (Request $request, NewsPost $newsPost) {
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:220'],
        'category' => ['required', Rule::in(['news', 'events', 'awards', 'lectures'])],
        'published_at' => ['nullable', 'date'],
        'image_url' => ['nullable', 'string', 'max:500'],
        'body' => ['required', 'string', 'max:8000'],
        'source_label' => ['nullable', 'string', 'max:120'],
        'source_url' => ['nullable', 'string', 'max:500'],
    ]);

    $validated['published'] = $request->boolean('published');

    $newsPost->update($validated);

    return redirect()->route('admin.dashboard')->with('status', 'News post updated.');
})->middleware('auth')->name('admin.news.update');

Route::post('/admin/projects', function (Request $request) {
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:160'],
        'slug' => ['nullable', 'string', 'max:180', Rule::unique('projects', 'slug')],
        'location' => ['required', 'string', 'max:160'],
        'year' => ['required', 'string', 'max:40'],
        'client' => ['required', 'string', 'max:180'],
        'typology' => ['required', 'string', 'max:120'],
        'size' => ['required', 'string', 'max:120'],
        'status' => ['required', 'string', 'max:120'],
        'hero_image' => ['required', 'string', 'max:500'],
        'summary' => ['required', 'string', 'max:4000'],
    ]);

    $baseSlug = Str::slug($validated['slug'] ?: $validated['title']);
    $slug = $baseSlug;
    $counter = 2;

    while (Project::where('slug', $slug)->exists()) {
        $slug = $baseSlug.'-'.$counter;
        $counter += 1;
    }

    $validated['slug'] = $slug;
    $validated['featured'] = $request->boolean('featured');

    Project::create($validated);

    return redirect()->route('admin.dashboard')->with('status', 'Project added.');
})->middleware('auth')->name('admin.projects.store');

Route::patch('/admin/projects/{project}', function (Request $request, Project $project) {
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:160'],
        'slug' => ['nullable', 'string', 'max:180', Rule::unique('projects', 'slug')->ignore($project)],
        'location' => ['required', 'string', 'max:160'],
        'year' => ['required', 'string', 'max:40'],
        'client' => ['required', 'string', 'max:180'],
        'typology' => ['required', 'string', 'max:120'],
        'size' => ['required', 'string', 'max:120'],
        'status' => ['required', 'string', 'max:120'],
        'hero_image' => ['required', 'string', 'max:500'],
        'summary' => ['required', 'string', 'max:4000'],
    ]);

    $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
    $validated['featured'] = $request->boolean('featured');

    $project->update($validated);

    return redirect()->route('admin.dashboard')->with('status', 'Project updated.');
})->middleware('auth')->name('admin.projects.update');

Route::post('/admin/projects/{project}/chapters', function (Request $request, Project $project) {
    $validated = $request->validate([
        'position' => ['required', 'integer', 'min:1', 'max:99'],
        'label' => ['required', 'string', 'max:140'],
        'image' => ['required', 'string', 'max:500'],
        'body' => ['required', 'string', 'max:4000'],
    ]);

    $project->chapters()->create($validated);

    return redirect()->route('admin.dashboard')->with('status', 'Project plan added.');
})->middleware('auth')->name('admin.project-chapters.store');

Route::patch('/admin/project-chapters/{chapter}', function (Request $request, ProjectChapter $chapter) {
    $validated = $request->validate([
        'position' => ['required', 'integer', 'min:1', 'max:99'],
        'label' => ['required', 'string', 'max:140'],
        'image' => ['required', 'string', 'max:500'],
        'body' => ['required', 'string', 'max:4000'],
    ]);

    $chapter->update($validated);

    return redirect()->route('admin.dashboard')->with('status', 'Project plan updated.');
})->middleware('auth')->name('admin.project-chapters.update');

Route::patch('/admin/services/{service}', function (Request $request, Service $service) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:120'],
        'description' => ['required', 'string', 'max:2000'],
        'position' => ['required', 'integer', 'min:1', 'max:99'],
    ]);

    $service->update($validated);

    return redirect()->route('admin.dashboard')->with('status', 'Service updated.');
})->middleware('auth')->name('admin.services.update');

Route::get('/api/projects', function () {
    return Project::with(['chapters', 'credits'])->latest('year')->get();
})->name('api.projects');

Route::get('/api/projects/{project:slug}', function (Project $project) {
    return $project->load(['chapters' => fn ($query) => $query->orderBy('position'), 'credits']);
})->name('api.projects.show');
