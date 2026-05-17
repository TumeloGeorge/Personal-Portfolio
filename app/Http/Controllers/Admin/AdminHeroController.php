<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;

class AdminHeroController extends Controller
{
    public function edit()
    {
        $hero = Hero::instance();
        return view('admin.hero.edit', compact('hero'));
    }

    public function update(Request $request)
    {
        $hero = Hero::instance();

        $validated = $request->validate([
            'headline'            => ['required', 'string', 'max:100'],
            'subheadline'         => ['required', 'string', 'max:150'],
            'bio'                 => ['required', 'string', 'max:500'],
            'projects_count'      => ['required', 'integer', 'min:0'],
            'years_experience'    => ['required', 'integer', 'min:0'],
            'clients_count'       => ['required', 'integer', 'min:0'],
            'cta_primary_label'   => ['required', 'string', 'max:50'],
            'cta_secondary_label' => ['required', 'string', 'max:50'],
        ]);

        $hero->update($validated);

        return back()->with('success', 'Hero section updated successfully.');
    }
}