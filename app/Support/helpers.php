<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;

const WIA_PROJECT_IMAGE_WIDTH = 1600;
const WIA_PROJECT_IMAGE_HEIGHT = 900;

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
        wia_normalize_project_image($source);

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

if (! function_exists('wia_normalize_project_image')) {
    function wia_normalize_project_image(string $path): void
    {
        if (! extension_loaded('gd') || ! function_exists('imagecreatetruecolor')) {
            return;
        }

        $info = @getimagesize($path);
        if (! $info) {
            return;
        }

        [$sourceWidth, $sourceHeight] = $info;
        $mime = $info['mime'] ?? '';

        if ($sourceWidth === WIA_PROJECT_IMAGE_WIDTH && $sourceHeight === WIA_PROJECT_IMAGE_HEIGHT) {
            return;
        }

        $bytes = @file_get_contents($path);
        if ($bytes === false) {
            return;
        }

        $source = @imagecreatefromstring($bytes);
        if (! $source) {
            return;
        }

        $target = imagecreatetruecolor(WIA_PROJECT_IMAGE_WIDTH, WIA_PROJECT_IMAGE_HEIGHT);
        $fill = imagecolorallocate($target, 255, 255, 255);
        imagefill($target, 0, 0, $fill);

        $sourceRatio = $sourceWidth / $sourceHeight;
        $targetRatio = WIA_PROJECT_IMAGE_WIDTH / WIA_PROJECT_IMAGE_HEIGHT;

        if ($sourceRatio > $targetRatio) {
            $cropHeight = $sourceHeight;
            $cropWidth = (int) round($sourceHeight * $targetRatio);
            $sourceX = (int) floor(($sourceWidth - $cropWidth) / 2);
            $sourceY = 0;
        } else {
            $cropWidth = $sourceWidth;
            $cropHeight = (int) round($sourceWidth / $targetRatio);
            $sourceX = 0;
            $sourceY = (int) floor(($sourceHeight - $cropHeight) / 2);
        }

        imagecopyresampled(
            $target,
            $source,
            0,
            0,
            $sourceX,
            $sourceY,
            WIA_PROJECT_IMAGE_WIDTH,
            WIA_PROJECT_IMAGE_HEIGHT,
            $cropWidth,
            $cropHeight
        );

        if ($mime === 'image/png') {
            imagepng($target, $path, 8);
        } elseif ($mime === 'image/webp' && function_exists('imagewebp')) {
            imagewebp($target, $path, 86);
        } else {
            imagejpeg($target, $path, 86);
        }

        imagedestroy($source);
        imagedestroy($target);
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
