<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->get();
        return view('admin.projects.index', ['projects' => $projects]);
    }

    public function create()
    {
        return view('admin.projects.create', []);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => ['required', 'string', 'max:200'],
            'description'    => ['required', 'string', 'max:1000'],
            'category'       => ['required', 'string', 'max:100'],
            'project_url'    => ['nullable', 'url', 'max:255'],
            'case_study_url' => ['nullable', 'url', 'max:255'],
            'featured'       => ['nullable', 'boolean'],
            'sort_order'     => ['nullable', 'integer', 'min:0'],
            'thumbnail'      => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_path'] = $request->file('thumbnail')
                ->store('projects', 'public');
        }

        $validated['featured'] = $request->boolean('featured');

        Project::create($validated);
        return redirect()->route('admin.projects.index')->with('success', 'Project added.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', ['project' => $project]);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'          => ['required', 'string', 'max:200'],
            'description'    => ['required', 'string', 'max:1000'],
            'category'       => ['required', 'string', 'max:100'],
            'project_url'    => ['nullable', 'url', 'max:255'],
            'case_study_url' => ['nullable', 'url', 'max:255'],
            'featured'       => ['nullable', 'boolean'],
            'sort_order'     => ['nullable', 'integer', 'min:0'],
            'thumbnail'      => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail_path) {
                Storage::disk('public')->delete($project->thumbnail_path);
            }
            $validated['thumbnail_path'] = $request->file('thumbnail')
                ->store('projects', 'public');
        }

        $validated['featured'] = $request->boolean('featured');

        $project->update($validated);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        if ($project->thumbnail_path) {
            Storage::disk('public')->delete($project->thumbnail_path);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }
}