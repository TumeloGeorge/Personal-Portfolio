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
        $certifications = Certification::orderBy('sort_order', 'asc')->get();
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
                ->store('certificates');
        }

        if ($request->hasFile('badge_image')) {
            $validated['badge_image_path'] = $request->file('badge_image')
                ->store('badges');
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

        $oldCertificatePath = null;
        $oldBadgePath = null;
        if ($request->hasFile('certificate_file')) {
            $oldCertificatePath = $certification->certificate_file_path;
            $validated['certificate_file_path'] = $request->file('certificate_file')
                ->store('certificates');
        }

        if ($request->hasFile('badge_image')) {
            $oldBadgePath = $certification->badge_image_path;
            $validated['badge_image_path'] = $request->file('badge_image')
                ->store('badges');
        }

        $certification->update($validated);
        if ($oldCertificatePath) {
            Storage::disk()->delete($oldCertificatePath);
        }
        if ($oldBadgePath) {
            Storage::disk()->delete($oldBadgePath);
        }
        return redirect()->route('admin.certifications.index')->with('success', 'Certification updated.');
    }

    public function destroy(Certification $certification)
    {
        if ($certification->certificate_file_path) {
            Storage::disk()->delete($certification->certificate_file_path);
        }
        if ($certification->badge_image_path) {
            Storage::disk()->delete($certification->badge_image_path);
        }
        Certification::destroy($certification->id);
        return redirect()->route('admin.certifications.index')->with('success', 'Certification deleted.');
    }
}