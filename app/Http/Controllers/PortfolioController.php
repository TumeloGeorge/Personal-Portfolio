<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Hero;
use App\Models\SkillCategory;
use App\Models\Experience;
use App\Models\Certification;
use App\Models\Project;

class PortfolioController extends Controller
{
    public function index()
    {
        $settings     = Setting::instance();
        $hero         = Hero::instance();
        $skillCats    = SkillCategory::with('skills')->orderBy('sort_order')->get();
        $experiences  = Experience::orderBy('sort_order')->get();
        $certifications = Certification::orderBy('sort_order')->get();
        $projects     = Project::orderBy('sort_order')->get();
        $categories   = $projects->pluck('category')->unique()->values();

        return view('portfolio.index', [
            'settings'       => $settings,
            'hero'           => $hero,
            'skillCats'      => $skillCats,
            'experiences'    => $experiences,
            'certifications' => $certifications,
            'projects'       => $projects,
            'categories'     => $categories,
        ]);
    }
}