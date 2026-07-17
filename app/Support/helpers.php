<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;

if (! function_exists('wia_project_categories')) {
    function wia_project_categories(): array
    {
        return [
            'architecture' => 'Architecture',
            'interiors' => 'Interiors',
            'planning' => 'Planning',
            'furniture' => 'Furniture',
            'landscape' => 'Landscape',
        ];
    }
}

if (! function_exists('wia_project_typology')) {
    function wia_project_typology(string $category, ?string $detail): string
    {
        $label = wia_project_categories()[$category] ?? Str::title($category);
        $detail = trim((string) $detail);

        return $detail === '' ? $label : $label.' - '.$detail;
    }
}

if (! function_exists('wia_store_uploaded_image')) {
    function wia_store_uploaded_image(Request $request, string $field): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);
        $directory = public_path('assets/uploads/projects');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image';
        $filename = $name.'-'.Str::random(8).'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        $source = $directory.DIRECTORY_SEPARATOR.$filename;
        $publicHtmlDirectory = dirname(base_path()).DIRECTORY_SEPARATOR.'public_html'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'projects';

        if (is_dir(dirname(base_path()).DIRECTORY_SEPARATOR.'public_html')) {
            if (! is_dir($publicHtmlDirectory)) {
                mkdir($publicHtmlDirectory, 0755, true);
            }

            $target = $publicHtmlDirectory.DIRECTORY_SEPARATOR.$filename;
            if (realpath($directory) !== realpath($publicHtmlDirectory)) {
                copy($source, $target);
            }
        }

        return '/assets/uploads/projects/'.$filename;
    }
}

if (! function_exists('wia_media_url')) {
    function wia_media_url(?string $url): string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return '';
        }

        if (preg_match('/^(https?:)?\/\//i', $url) || str_starts_with($url, 'data:')) {
            return $url;
        }

        $path = ltrim($url, '/');
        $base = rtrim(request()->getBaseUrl(), '/');

        return ($base === '' ? '' : $base).'/'.$path;
    }
}

if (! function_exists('wia_apply_project_slide_uploads')) {
    function wia_apply_project_slide_uploads(Request $request, array $validated): array
    {
        foreach (['overview_image', 'spatial_image', 'material_image', 'delivery_image'] as $field) {
            $uploadedImage = wia_store_uploaded_image($request, $field.'_file');
            if ($uploadedImage) {
                $validated[$field] = $uploadedImage;
            }

            unset($validated[$field.'_file']);
        }

        return $validated;
    }
}
