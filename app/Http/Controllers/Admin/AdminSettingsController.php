<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    public function edit()
    {
        $settings = Setting::instance();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::instance();

        $validated = $request->validate([
            'site_name'          => ['required', 'string', 'max:100'],
            'full_name'          => ['required', 'string', 'max:100'],
            'role_title'         => ['required', 'string', 'max:150'],
            'short_bio'          => ['required', 'string', 'max:500'],
            'accent_color'       => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'email'              => ['nullable', 'email', 'max:100'],
            'phone'              => ['nullable', 'string', 'max:30'],
            'location'           => ['nullable', 'string', 'max:100'],
            'linkedin_url'       => ['nullable', 'url', 'max:255'],
            'behance_url'        => ['nullable', 'url', 'max:255'],
            'dribbble_url'       => ['nullable', 'url', 'max:255'],
            'github_url'         => ['nullable', 'url', 'max:255'],
            'available_for_work' => ['boolean'],
            'avatar'             => ['nullable', 'image', 'max:2048'],
            'cv'                 => ['nullable', 'mimes:pdf', 'max:5120'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($settings->avatar_path) {
                Storage::disk('public')->delete($settings->avatar_path);
            }
            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Handle CV upload
        if ($request->hasFile('cv')) {
            if ($settings->cv_path) {
                Storage::disk('public')->delete($settings->cv_path);
            }
            $validated['cv_path'] = $request->file('cv')->store('cv', 'public');
        }

        $validated['available_for_work'] = $request->boolean('available_for_work');

        $settings->update($validated);

        return back()->with('success', 'Settings updated successfully.');
    }
}