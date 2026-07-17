<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private function keepExistingUpload(?string $current, ?string $fallback): ?string
    {
        return str_starts_with((string) $current, '/assets/uploads/') ? $current : $fallback;
    }

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@wia.test')],
            [
                'name' => env('ADMIN_NAME', 'WIA Admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            ],
        );

        $projects = [
            [
                'slug' => 'yellow-house',
                'title' => 'Yellow House',
                'location' => 'Mutito Andei, Kenya',
                'year' => '2026',
                'client' => 'Hekima Farm',
                'typology' => 'Architecture',
                'size' => 'One-bedroom VIP retreat',
                'status' => 'Completed',
                'hero_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'Standing as the first imprint of Hekima Farm\'s vision, Yellow House is more than just a structure. It is a statement of intent: a one-bedroom VIP retreat that balances intimacy with openness, tradition with modernity, and nature with comfort.',
                'featured' => true,
                'chapters' => [
                    [
                        'position' => 1,
                        'label' => 'A Warm Retreat',
                        'body' => 'Designed as a sanctuary for rest and reconnection, Yellow House invites families to unwind and experience the gentle rhythm of Mutito Andei\'s landscape. It is the architectural embodiment of a warm embrace.',
                        'image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1500&q=82',
                    ],
                    [
                        'position' => 2,
                        'label' => 'Spatial Fluidity',
                        'body' => 'At its core, the chalet is a masterclass in spatial fluidity. The open-plan layout seamlessly integrates the lounge, kitchen, and utility room, fostering a quiet sense of connectedness between functions.',
                        'image' => 'https://images.unsplash.com/photo-1600607688969-a5bfcd646154?auto=format&fit=crop&w=1500&q=82',
                    ],
                    [
                        'position' => 3,
                        'label' => 'Life Under The Eaves',
                        'body' => 'Two expansive eaves extend the living space beyond its walls, blurring the boundary between indoors and outdoors. These shaded outdoor rooms hold sunrise, midday heat, breeze, and gathering with equal ease.',
                        'image' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1500&q=82',
                    ],
                    [
                        'position' => 4,
                        'label' => 'Light And Landscape',
                        'body' => 'Whether bathed in golden morning light or protected from the harsh midday sun, the house creates a dynamic interplay of light, shadow, and air, allowing residents to fully immerse themselves in the land’s tranquility.',
                        'image' => 'https://images.unsplash.com/photo-1600566752355-35792bedcfea?auto=format&fit=crop&w=1500&q=82',
                    ],
                    [
                        'position' => 5,
                        'label' => 'Material Honesty',
                        'body' => 'The exterior is built from precisely cut machine stone and finished with Ruff and Tuff, giving it a textured resilience that speaks to endurance and craft. Inside, skimmed walls and double-layered paint create a refined, velvety contrast to the rugged shell.',
                        'image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1500&q=82',
                    ],
                ],
                'credits' => [
                    ['role' => 'Design Lead', 'name' => 'WIA Studio'],
                    ['role' => 'Client', 'name' => 'Hekima Farm'],
                    ['role' => 'Project Type', 'name' => 'VIP Retreat / Chalet'],
                ],
            ],
            [
                'slug' => 'karura-courtyard-house',
                'title' => 'Karura Courtyard House',
                'location' => 'Nairobi, Kenya',
                'year' => '2026',
                'client' => 'Private Family',
                'typology' => 'Residential',
                'size' => '820 / 8,825',
                'status' => 'Design Development',
                'hero_image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A low-slung family home that wraps daily rituals around a planted courtyard, drawing Karura forest light deep into the plan.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'SITE', 'body' => 'The house begins with the forest edge. Public rooms face the garden, while quieter bedrooms tuck behind a textured stone wall.', 'image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'COURTYARD', 'body' => 'A planted void becomes the climatic engine of the home, pulling air, shade, and soft light through every room.', 'image' => 'https://images.unsplash.com/photo-1600607688969-a5bfcd646154?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 3, 'label' => 'ROOF', 'body' => 'The lifted roofline catches rainwater and opens a clerestory band above the living spaces.', 'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Design Lead', 'name' => 'Hiuhu Wia'],
                    ['role' => 'Project Architect', 'name' => 'Amina Njoroge'],
                    ['role' => 'Landscape', 'name' => 'WIA Studio Landscape Unit'],
                ],
            ],
            [
                'slug' => 'kileleshwa-studio-lofts',
                'title' => 'Kileleshwa Studio Lofts',
                'location' => 'Nairobi, Kenya',
                'year' => '2025',
                'client' => 'Urban Habitat Ltd',
                'typology' => 'Work / Residential',
                'size' => '4,600 / 49,514',
                'status' => 'Planning Approval',
                'hero_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A compact live-work building organized around shaded galleries, flexible studio bays, and shared terraces.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'STACK', 'body' => 'Studio units stack around a shared stair, turning circulation into a social spine rather than leftover space.', 'image' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'SCREEN', 'body' => 'Deep balconies and perforated metal screens temper the equatorial sun while giving each studio a small outdoor room.', 'image' => 'https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Design Lead', 'name' => 'Hiuhu Wia'],
                    ['role' => 'Planning', 'name' => 'Nairobi Urban Advisory'],
                ],
            ],
            [
                'slug' => 'limuru-learning-pavilion',
                'title' => 'Limuru Learning Pavilion',
                'location' => 'Limuru, Kenya',
                'year' => '2024',
                'client' => 'Greenfield Academy',
                'typology' => 'Education',
                'size' => '1,150 / 12,378',
                'status' => 'Completed',
                'hero_image' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'Timber classrooms and outdoor rooms stitched into a sloped tea landscape, designed for daylight and cross ventilation.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'TERRAIN', 'body' => 'Classrooms step with the hillside, preserving mature trees and making outdoor teaching spaces between blocks.', 'image' => 'https://images.unsplash.com/photo-1554995207-c18c203602cb?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'VERANDA', 'body' => 'Covered verandas provide circulation, shade, and informal breakout space through the school day.', 'image' => 'https://images.unsplash.com/photo-1600573472591-ee6b68d14c68?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Design Lead', 'name' => 'WIA Studio'],
                    ['role' => 'Contractor', 'name' => 'Mbao Works'],
                ],
            ],
            [
                'slug' => 'lavington-garden-villas',
                'title' => 'Lavington Garden Villas',
                'location' => 'Lavington, Nairobi',
                'year' => '2026',
                'client' => 'Palm Ridge Developments',
                'typology' => 'Residential',
                'size' => '3,200 / 34,445',
                'status' => 'Tender',
                'hero_image' => 'https://images.unsplash.com/photo-1600566752355-35792bedcfea?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A collection of courtyard villas arranged as a quiet residential garden, balancing privacy, shared landscape, and generous family living.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'CLUSTER', 'body' => 'The villas are offset around planted courts so each home receives privacy, cross ventilation, and a direct relationship to landscape.', 'image' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'THRESHOLD', 'body' => 'Deep entry porches, stone walls, and timber screens create a layered arrival sequence from street to living room.', 'image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 3, 'label' => 'GARDEN', 'body' => 'Shared paths and private terraces are designed as one continuous landscape, reducing hardscape and improving stormwater absorption.', 'image' => 'https://images.unsplash.com/photo-1600607688969-a5bfcd646154?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Design Lead', 'name' => 'Hiuhu Wia'],
                    ['role' => 'Project Architect', 'name' => 'Miriam Akoth'],
                    ['role' => 'Quantity Surveyor', 'name' => 'CostPlan Kenya'],
                ],
            ],
            [
                'slug' => 'upper-hill-workplace-campus',
                'title' => 'Upper Hill Workplace Campus',
                'location' => 'Upper Hill, Nairobi',
                'year' => '2025',
                'client' => 'Apex Capital Group',
                'typology' => 'Work',
                'size' => '18,400 / 198,056',
                'status' => 'Concept Design',
                'hero_image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A flexible office campus with shaded atria, shared meeting landscapes, and a public ground floor that opens the workplace to the city.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'GROUND', 'body' => 'Retail, reception, and civic meeting rooms form an active ground plane instead of a sealed office lobby.', 'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'ATRIUM', 'body' => 'A shaded atrium draws air through the floor plates and gives every workplace a visual connection to shared space.', 'image' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 3, 'label' => 'FACADE', 'body' => 'The facade combines vertical fins and recessed glazing to reduce heat gain while keeping views open.', 'image' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Design Lead', 'name' => 'WIA Studio'],
                    ['role' => 'Sustainability', 'name' => 'GreenLine Consultants'],
                    ['role' => 'Structural Engineer', 'name' => 'FrameWorks Africa'],
                ],
            ],
            [
                'slug' => 'diani-coastal-retreat',
                'title' => 'Diani Coastal Retreat',
                'location' => 'Diani, Kwale',
                'year' => '2025',
                'client' => 'Private Hospitality Client',
                'typology' => 'Hospitality',
                'size' => '2,750 / 29,601',
                'status' => 'Design Development',
                'hero_image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A small coastal retreat of guest pavilions, breezeways, and shaded decks designed around sea wind, coral stone, and outdoor living.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'BREEZE', 'body' => 'Guest pavilions are staggered to catch the monsoon breeze while protecting privacy between rooms.', 'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'DECK', 'body' => 'A continuous timber deck connects pool, dining, and lounge spaces without closing them off from the landscape.', 'image' => 'https://images.unsplash.com/photo-1602002418082-a4443e081dd1?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 3, 'label' => 'MATERIAL', 'body' => 'Coral stone, lime plaster, and woven screens give the retreat a quiet coastal texture with low maintenance demands.', 'image' => 'https://images.unsplash.com/photo-1600607687644-aac4c3eac7f4?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Design Lead', 'name' => 'Hiuhu Wia'],
                    ['role' => 'Interior Design', 'name' => 'WIA Interiors'],
                    ['role' => 'Landscape', 'name' => 'Coast Botanical Studio'],
                ],
            ],
            [
                'slug' => 'muthaiga-house-interiors',
                'title' => 'Muthaiga House Interiors',
                'location' => 'Muthaiga, Nairobi',
                'year' => '2024',
                'client' => 'Private Family',
                'typology' => 'Interiors',
                'size' => '540 / 5,813',
                'status' => 'Completed',
                'hero_image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A complete interior renewal of a family home, using warm timber, textured stone, and calm lighting to create a refined everyday atmosphere.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'LIVING', 'body' => 'The living room is organized around low furniture, concealed storage, and a continuous stone hearth.', 'image' => 'https://images.unsplash.com/photo-1600210491369-e753d80a41f3?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'LIGHTING', 'body' => 'Layered lighting allows the home to shift from bright family use to a softer evening atmosphere.', 'image' => 'https://images.unsplash.com/photo-1600566752229-250ed79470f8?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 3, 'label' => 'DETAIL', 'body' => 'Bespoke joinery conceals services and gives each room a consistent material rhythm.', 'image' => 'https://images.unsplash.com/photo-1615873968403-89e068629265?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Interior Lead', 'name' => 'WIA Interiors'],
                    ['role' => 'Furniture', 'name' => 'Nairobi Joinery Works'],
                    ['role' => 'Lighting', 'name' => 'Luma Studio'],
                ],
            ],
            [
                'slug' => 'ngong-view-masterplan',
                'title' => 'Ngong View Masterplan',
                'location' => 'Kajiado County, Kenya',
                'year' => '2024',
                'client' => 'Savanna Communities Ltd',
                'typology' => 'Planning',
                'size' => '42 ha / 104 ac',
                'status' => 'Planning Approval',
                'hero_image' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A hillside residential masterplan that protects view corridors, stormwater paths, and community amenities across a sensitive landscape.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'TERRAIN', 'body' => 'Development parcels follow the contours to reduce cut-and-fill and preserve long views toward the Ngong Hills.', 'image' => 'https://images.unsplash.com/photo-1473773508845-188df298d2d1?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'WATER', 'body' => 'Seasonal water channels are kept open as linear parks and stormwater infrastructure.', 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 3, 'label' => 'COMMUNITY', 'body' => 'Schools, shops, and shared gardens are placed within walking distance of every residential cluster.', 'image' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Urban Design', 'name' => 'WIA Studio'],
                    ['role' => 'Planning Consultant', 'name' => 'CountyWorks Advisory'],
                    ['role' => 'Civil Engineer', 'name' => 'Axis Infrastructure'],
                ],
            ],
            [
                'slug' => 'kilimani-retail-court',
                'title' => 'Kilimani Retail Court',
                'location' => 'Kilimani, Nairobi',
                'year' => '2023',
                'client' => 'Market Lane Partners',
                'typology' => 'Commercial',
                'size' => '3,850 / 41,441',
                'status' => 'Completed',
                'hero_image' => 'https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A neighborhood retail court organized around a shaded courtyard, flexible shopfronts, and an upper-level dining terrace.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'COURT', 'body' => 'The central court creates a calm pedestrian space away from the traffic edge while keeping shopfronts visible.', 'image' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'SHADE', 'body' => 'A steel canopy and planted edges reduce heat while maintaining an open-air shopping experience.', 'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 3, 'label' => 'FRONTAGE', 'body' => 'The street frontage is broken into small bays so different tenants can adapt signage and seating without visual clutter.', 'image' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Design Lead', 'name' => 'WIA Studio'],
                    ['role' => 'Project Manager', 'name' => 'BuildPoint Kenya'],
                    ['role' => 'Contractor', 'name' => 'Eastline Contractors'],
                ],
            ],
            [
                'slug' => 'two-rivers-landscape-rooms',
                'title' => 'Two Rivers Landscape Rooms',
                'location' => 'Runda, Nairobi',
                'year' => '2023',
                'client' => 'Lifestyle Precinct Ltd',
                'typology' => 'Landscape',
                'size' => '6,900 / 74,271',
                'status' => 'Completed',
                'hero_image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A sequence of outdoor rooms for dining, events, and quiet pause, using planting, water, and shade structures to organize a public precinct.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'ROOMS', 'body' => 'Planting walls, low seating, and shade frames define outdoor rooms without blocking movement through the precinct.', 'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'WATER', 'body' => 'A shallow water spine cools the microclimate and helps visitors orient themselves.', 'image' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 3, 'label' => 'EVENT', 'body' => 'Flexible terraces support markets, talks, and evening events without requiring temporary infrastructure for every use.', 'image' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Landscape Lead', 'name' => 'WIA Studio'],
                    ['role' => 'Horticulture', 'name' => 'GreenRoot Kenya'],
                    ['role' => 'Lighting', 'name' => 'Luma Studio'],
                ],
            ],
            [
                'slug' => 'kisumu-lakefront-library',
                'title' => 'Kisumu Lakefront Library',
                'location' => 'Kisumu, Kenya',
                'year' => '2022',
                'client' => 'County Cultural Office',
                'typology' => 'Culture',
                'size' => '2,100 / 22,604',
                'status' => 'Competition',
                'hero_image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1800&q=82',
                'summary' => 'A public library proposal that opens reading rooms toward Lake Victoria and uses a shaded civic veranda as its main public threshold.',
                'featured' => true,
                'chapters' => [
                    ['position' => 1, 'label' => 'VERANDA', 'body' => 'A long public veranda becomes the social heart of the library, welcoming readers before they enter the cooled interior.', 'image' => 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 2, 'label' => 'READING', 'body' => 'Reading rooms are arranged by sound level, from active children spaces to quiet research rooms facing the lake.', 'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1500&q=82'],
                    ['position' => 3, 'label' => 'ROOF', 'body' => 'The roof collects rainwater, shades the facade, and creates a recognizable civic silhouette on the lakefront.', 'image' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=1500&q=82'],
                ],
                'credits' => [
                    ['role' => 'Design Lead', 'name' => 'WIA Studio'],
                    ['role' => 'Cultural Advisor', 'name' => 'Kisumu Arts Forum'],
                    ['role' => 'Environmental Consultant', 'name' => 'Lake Basin Ecology Lab'],
                ],
            ],
        ];

        foreach ($projects as $data) {
            $chapters = $data['chapters'];
            $credits = $data['credits'];
            unset($data['chapters'], $data['credits']);

            $existingProject = Project::where('slug', $data['slug'])->with('chapters')->first();
            if ($existingProject) {
                foreach (['hero_image', 'overview_image', 'spatial_image', 'material_image', 'delivery_image'] as $field) {
                    $data[$field] = $this->keepExistingUpload($existingProject->{$field}, $data[$field] ?? null);
                }

                $existingChapters = $existingProject->chapters->keyBy('position');
                $chapters = collect($chapters)
                    ->map(function (array $chapter) use ($existingChapters) {
                        $existingChapter = $existingChapters->get($chapter['position']);
                        $chapter['image'] = $this->keepExistingUpload($existingChapter?->image, $chapter['image'] ?? null);

                        return $chapter;
                    })
                    ->all();
            }

            $project = Project::updateOrCreate(['slug' => $data['slug']], $data);
            $project->chapters()->delete();
            $project->credits()->delete();
            $project->chapters()->createMany($chapters);
            $project->credits()->createMany($credits);
        }

        collect([
            ['name' => 'Architecture', 'description' => 'Concept design, approvals, technical drawings, and construction documentation.', 'position' => 1],
            ['name' => 'Interior Design', 'description' => 'Material palettes, lighting, furniture, joinery, and complete interior packages.', 'position' => 2],
            ['name' => 'Master Planning', 'description' => 'Site strategy for residential estates, mixed-use developments, and civic places.', 'position' => 3],
            ['name' => 'Project Management', 'description' => 'Budget, programme, site coordination, and quality control through handover.', 'position' => 4],
            ['name' => '3D Visualisation', 'description' => 'Still renders, walkthroughs, and presentation assets for design communication.', 'position' => 5],
            ['name' => 'Feasibility Studies', 'description' => 'Zoning, site constraints, cost checks, and early design risk assessment.', 'position' => 6],
        ])->each(fn ($service) => Service::updateOrCreate(['name' => $service['name']], $service));
    }
}
