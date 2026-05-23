<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Hero;
use App\Models\SkillCategory;
use App\Models\Experience;
use App\Models\Certification;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PortfolioController extends Controller
{
    public function index()
    {
        $settings       = Setting::instance();
        $hero           = Hero::instance();
        $skillCats      = SkillCategory::with('skills')->orderBy('sort_order')->get();
        $experiences    = Experience::orderBy('sort_order')->get();
        $certifications = Certification::orderBy('sort_order')->get();
        $projects       = Project::orderBy('sort_order')->get();
        $categories     = $projects->pluck('category')->unique()->values();

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

    /**
     * Force-download the CV file stored in public disk.
     */
    public function downloadCv(): StreamedResponse
    {
        $settings = Setting::instance();

        abort_if(!$settings->cv_path, 404, 'No CV uploaded yet.');
        abort_if(!Storage::disk('public')->exists($settings->cv_path), 404, 'CV file not found.');

        $filename = $settings->full_name . ' - CV.pdf';

        return Storage::disk('public')->download($settings->cv_path, $filename);
    }

    /**
     * Force-download a certification file.
     */
    public function downloadCertificate(\App\Models\Certification $certification): StreamedResponse
    {
        abort_if(!$certification->certificate_file_path, 404, 'No certificate file uploaded.');
        abort_if(!Storage::disk('public')->exists($certification->certificate_file_path), 404, 'Certificate file not found.');

        $ext      = pathinfo($certification->certificate_file_path, PATHINFO_EXTENSION);
        $filename = $certification->name . ' - ' . $certification->issuing_body . '.' . $ext;

        return Storage::disk('public')->download($certification->certificate_file_path, $filename);
    }
}