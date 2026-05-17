<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class AdminExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('sort_order')->get();
        return view('admin.experiences.index', ['experiences' => $experiences]);
    }

    public function create()
    {
        return view('admin.experiences.create', []);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_title'   => ['required', 'string', 'max:150'],
            'company'     => ['required', 'string', 'max:150'],
            'start_year'  => ['required', 'digits:4', 'integer', 'min:1900', 'max:2099'],
            'end_year'    => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:2099'],
            'description' => ['required', 'string', 'max:1000'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        Experience::create($validated);
        return redirect()->route('admin.experiences.index')->with('success', 'Experience added.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', ['experience' => $experience]);
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'job_title'   => ['required', 'string', 'max:150'],
            'company'     => ['required', 'string', 'max:150'],
            'start_year'  => ['required', 'digits:4', 'integer', 'min:1900', 'max:2099'],
            'end_year'    => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:2099'],
            'description' => ['required', 'string', 'max:1000'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        $experience->update($validated);
        return redirect()->route('admin.experiences.index')->with('success', 'Experience updated.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('admin.experiences.index')->with('success', 'Experience deleted.');
    }
}