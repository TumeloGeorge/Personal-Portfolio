<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Hero;
use App\Models\SkillCategory;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Certification;
use App\Models\Project;

class DefaultContentSeeder extends Seeder
{
    public function run(): void
    {
        // Settings
        Setting::updateOrCreate([], [
            'site_name'          => 'Tim Tom',
            'full_name'          => 'Tim Tom',
            'role_title'         => 'UI/UX & Graphic Designer',
            'short_bio'          => 'Crafting digital experiences that feel human. I design interfaces, brand identities, and visual systems that bridge function and beauty.',
            'accent_color'       => '#38bdf8',
            'email'              => 'hello@timtom.design',
            'location'           => 'Gaborone, Botswana',
            'linkedin_url'       => 'https://linkedin.com/in/timtom',
            'behance_url'        => 'https://behance.net/timtom',
            'available_for_work' => true,
        ]);

        // Hero
        Hero::updateOrCreate([], [
            'headline'            => 'Tim Tom',
            'subheadline'         => 'UI/UX & Graphic Designer',
            'bio'                 => 'Crafting digital experiences that feel human. I design interfaces, brand identities, and visual systems that bridge function and beauty.',
            'projects_count'      => 32,
            'years_experience'    => 5,
            'clients_count'       => 12,
            'cta_primary_label'   => 'View Projects',
            'cta_secondary_label' => 'Download CV',
        ]);

        // Skill categories + skills
        $categories = [
            ['name' => 'UI/UX Design', 'icon' => 'ti-layout', 'skills' => [
                ['name' => 'Figma', 'level' => 'primary'],
                ['name' => 'Prototyping', 'level' => 'primary'],
                ['name' => 'Wireframing', 'level' => 'primary'],
                ['name' => 'User Research', 'level' => 'primary'],
            ]],
            ['name' => 'Visual Design', 'icon' => 'ti-palette', 'skills' => [
                ['name' => 'Illustrator', 'level' => 'primary'],
                ['name' => 'Photoshop', 'level' => 'primary'],
                ['name' => 'After Effects', 'level' => 'primary'],
                ['name' => 'Branding', 'level' => 'primary'],
            ]],
            ['name' => 'Front-end', 'icon' => 'ti-code', 'skills' => [
                ['name' => 'HTML/CSS', 'level' => 'primary'],
                ['name' => 'React', 'level' => 'secondary'],
                ['name' => 'Tailwind', 'level' => 'secondary'],
            ]],
        ];

        foreach ($categories as $i => $cat) {
            $category = SkillCategory::updateOrCreate(
                ['name' => $cat['name']],
                ['icon' => $cat['icon'], 'sort_order' => $i]
            );
            foreach ($cat['skills'] as $j => $skill) {
                Skill::updateOrCreate(
                    ['skill_category_id' => $category->id, 'name' => $skill['name']],
                    ['level' => $skill['level'], 'sort_order' => $j]
                );
            }
        }

        // Experiences
        $experiences = [
            ['job_title' => 'Lead UI/UX Designer', 'company' => 'Creative Agency XYZ', 'start_year' => '2022', 'end_year' => null,   'description' => 'Led end-to-end product design for 8+ clients. Established design systems and guided junior designers.', 'sort_order' => 0],
            ['job_title' => 'Product Designer',     'company' => 'TechStartup Co.',     'start_year' => '2020', 'end_year' => '2022', 'description' => 'Designed mobile and web interfaces from concept to handoff, collaborating with dev teams daily.',          'sort_order' => 1],
            ['job_title' => 'Graphic Designer',     'company' => 'Studio Bravo',        'start_year' => '2018', 'end_year' => '2020', 'description' => 'Brand identity, print, and digital design across diverse client industries.',                               'sort_order' => 2],
        ];

        foreach ($experiences as $exp) {
            Experience::updateOrCreate(
                ['job_title' => $exp['job_title'], 'company' => $exp['company']],
                $exp
            );
        }

        // Certifications
        $certs = [
            ['name' => 'Google UX Design Certificate', 'issuing_body' => 'Google / Coursera', 'year' => '2023', 'sort_order' => 0],
            ['name' => 'Figma Advanced Design',        'issuing_body' => 'Figma Academy',     'year' => '2022', 'sort_order' => 1],
            ['name' => 'Adobe Certified Professional', 'issuing_body' => 'Adobe',             'year' => '2021', 'sort_order' => 2],
        ];

        foreach ($certs as $cert) {
            Certification::updateOrCreate(['name' => $cert['name']], $cert);
        }

        // Projects
        $projects = [
            ['title' => 'FinTech Dashboard Redesign', 'description' => 'Revamped the core analytics dashboard for a fintech client, increasing task completion by 40%.', 'category' => 'UI/UX',    'featured' => true,  'sort_order' => 0],
            ['title' => 'Brand Identity — Lumara',    'description' => 'Full brand system including logo, typography, color palette and brand guidelines.',              'category' => 'Branding', 'featured' => true,  'sort_order' => 1],
            ['title' => 'Health App — MediTrack',     'description' => 'End-to-end mobile UX for a health monitoring application across iOS and Android.',               'category' => 'Mobile',   'featured' => true,  'sort_order' => 2],
            ['title' => 'E-commerce Redesign',        'description' => 'UX overhaul and visual refresh of an e-commerce storefront, improving conversion rate.',         'category' => 'Web',      'featured' => false, 'sort_order' => 3],
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(['title' => $proj['title']], $proj);
        }
    }
}