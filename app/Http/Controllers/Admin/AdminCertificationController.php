<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::orderBy('sort_order')->get();
        return view('admin.certifications.index', ['certifications' => $certifications]);
    }

    public function create()
    {
        return view('admin.certifications.create', []);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:200'],
            'issuing_body'     => ['required', 'string', 'max:150'],
            'year'             => ['required', 'digits:4', 'integer', 'min:1900', 'max:2099'],
            'credential_url'   => ['nullable', 'url', 'max:255'],
            'sort_order'       => ['nullable', 'integer', 'min:0'],
            'certificate_file' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'badge_image'      => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('certificate_file')) {
            $validated['certificate_file_path'] = $request->file('certificate_file')
                ->store('certificates', 'public');
        }

        if ($request->hasFile('badge_image')) {
            $validated['badge_image_path'] = $request->file('badge_image')
                ->store('badges', 'public');
        }

        Certification::create($validated);
        return redirect()->route('admin.certifications.index')->with('success', 'Certification added.');
    }

    public function edit(Certification $certification)
    {
        return view('admin.certifications.edit', ['certification' => $certification]);
    }

    public function update(Request $request, Certification $certification)
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:200'],
            'issuing_body'     => ['required', 'string', 'max:150'],
            'year'             => ['required', 'digits:4', 'integer', 'min:1900', 'max:2099'],
            'credential_url'   => ['nullable', 'url', 'max:255'],
            'sort_order'       => ['nullable', 'integer', 'min:0'],
            'certificate_file' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'badge_image'      => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('certificate_file')) {
            if ($certification->certificate_file_path) {
                Storage::disk('public')->delete($certification->certificate_file_path);
            }
            $validated['certificate_file_path'] = $request->file('certificate_file')
                ->store('certificates', 'public');
        }

        if ($request->hasFile('badge_image')) {
            if ($certification->badge_image_path) {
                Storage::disk('public')->delete($certification->badge_image_path);
            }
            $validated['badge_image_path'] = $request->file('badge_image')
                ->store('badges', 'public');
        }

        $certification->update($validated);
        return redirect()->route('admin.certifications.index')->with('success', 'Certification updated.');
    }

    public function destroy(Certification $certification)
    {
        if ($certification->certificate_file_path) {
            Storage::disk('public')->delete($certification->certificate_file_path);
        }
        if ($certification->badge_image_path) {
            Storage::disk('public')->delete($certification->badge_image_path);
        }
        $certification->delete();
        return redirect()->route('admin.certifications.index')->with('success', 'Certification deleted.');
    }
}