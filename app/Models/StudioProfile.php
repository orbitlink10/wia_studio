<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'intro',
        'body',
        'vision',
        'image_one',
        'image_two',
        'contact_email',
        'phone_number',
        'footer_emails',
        'footer_offices',
        'footer_socials',
        'footer_legal',
        'architecture_text',
        'interiors_text',
        'landscape_text',
        'planning_text',
        'products_text',
    ];

    public static function defaults(): array
    {
        return [
            'intro' => 'WIA Studio is a Nairobi-based architecture, interiors, landscape, planning, and product design practice.',
            'body' => 'We pair architectural rigor with the realities of building in East Africa: climate, approvals, budget, craft, maintenance, and the daily rituals that make a place work.',
            'vision' => 'Our vision is to create thoughtful, resilient spaces that help people live, work, gather, and grow with dignity.',
            'image_one' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1600&q=82',
            'image_two' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=82',
            'contact_email' => 'studio@wia.com',
            'phone_number' => '+254 700 000 000',
            'footer_emails' => "Studio: studio@wia.com",
            'footer_offices' => "Nairobi: +254 700 000 000",
            'footer_socials' => "Instagram: https://instagram.com\nLinkedIn: https://linkedin.com",
            'footer_legal' => "Privacy\nTerms",
            'architecture_text' => 'Buildings shaped by context, proportion, light, climate, structure, and long-term use.',
            'interiors_text' => 'Interior environments with clear material choices, human scale, and everyday comfort.',
            'landscape_text' => 'Outdoor rooms, gardens, courtyards, and public grounds that connect people to place.',
            'planning_text' => 'Site strategy, feasibility, approvals, phasing, and frameworks for future growth.',
            'products_text' => 'Objects, furniture, lighting, and details that extend the architectural language into use.',
        ];
    }

    public static function current(): self
    {
        return static::query()->first() ?? new static(static::defaults());
    }

    public static function currentForUpdate(): self
    {
        return static::query()->firstOrCreate([], static::defaults());
    }
}
