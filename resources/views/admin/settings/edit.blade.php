@extends('admin.layouts.app')
@section('title', 'Settings')
@section('subtitle', 'Manage your site-wide settings and personal details')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

        {{-- LEFT COLUMN --}}
        <div style="display:flex; flex-direction:column; gap:20px;">

            {{-- Identity --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="ti ti-user"></i> Identity</div>
                </div>

                {{-- Avatar --}}
                <div class="form-group">
                    <label class="form-label">Profile Photo</label>
                    @if($settings->avatar_path)
                        <div style="margin-bottom:10px;">
                            <img src="{{ Storage::url($settings->avatar_path) }}" class="img-preview" alt="Avatar">
                        </div>
                    @endif
                    <div class="file-upload" onclick="document.getElementById('avatar').click()">
                        <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewFile(this,'avatar-preview')">
                        <i class="ti ti-upload"></i>
                        <p>Click to upload photo (JPG, PNG — max 2MB)</p>
                        <div class="filename" id="avatar-preview"></div>
                    </div>
                    @error('avatar')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" name="full_name" class="form-input" value="{{ old('full_name', $settings->full_name) }}" required>
                    @error('full_name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role / Title <span class="required">*</span></label>
                    <input type="text" name="role_title" class="form-input" value="{{ old('role_title', $settings->role_title) }}" placeholder="e.g. UI/UX & Graphic Designer" required>
                    @error('role_title')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Short Bio <span class="required">*</span></label>
                    <textarea name="short_bio" class="form-textarea" rows="4" required>{{ old('short_bio', $settings->short_bio) }}</textarea>
                    @error('short_bio')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Site Name</label>
                    <input type="text" name="site_name" class="form-input" value="{{ old('site_name', $settings->site_name) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Accent Color</label>
                    <div class="color-input-wrap">
                        <input type="color" id="accent_color_picker" value="{{ old('accent_color', $settings->accent_color) }}"
                            oninput="document.getElementById('accent_color').value=this.value">
                        <input type="text" name="accent_color" id="accent_color" class="form-input"
                            value="{{ old('accent_color', $settings->accent_color) }}"
                            oninput="document.getElementById('accent_color_picker').value=this.value"
                            style="width:120px;" placeholder="#38bdf8">
                        <div style="width:36px;height:36px;border-radius:8px;background:{{ $settings->accent_color }};border:1px solid #e2e8f0;" id="color-preview"></div>
                    </div>
                    @error('accent_color')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                        <input type="hidden" name="available_for_work" value="0">
                        <input type="checkbox" name="available_for_work" value="1" {{ $settings->available_for_work ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#38bdf8;">
                        Available for Work (shows green badge on hero)
                    </label>
                </div>
            </div>

            {{-- CV Upload --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="ti ti-file-cv"></i> CV / Resume</div>
                </div>
                @if($settings->cv_path)
                    <div style="margin-bottom:12px; padding:10px 14px; background:#f8fafc; border-radius:8px; border:1px solid #e2e8f0; font-size:12px; color:#374151; display:flex; align-items:center; gap:8px;">
                        <i class="ti ti-file-text" style="color:#38bdf8;"></i>
                        Current CV on file —
                        <a href="{{ Storage::url($settings->cv_path) }}" target="_blank" style="color:#38bdf8;">View</a>
                    </div>
                @endif
                <div class="file-upload" onclick="document.getElementById('cv').click()">
                    <input type="file" id="cv" name="cv" accept=".pdf" onchange="previewFile(this,'cv-preview')">
                    <i class="ti ti-upload"></i>
                    <p>Upload PDF (max 5MB)</p>
                    <div class="filename" id="cv-preview"></div>
                </div>
                @error('cv')<div class="form-error">{{ $message }}</div>@enderror
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div style="display:flex; flex-direction:column; gap:20px;">

            {{-- Contact Details --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="ti ti-address-book"></i> Contact Details</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $settings->email) }}">
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input" value="{{ old('phone', $settings->phone) }}" placeholder="+267 71 000 000">
                </div>

                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-input" value="{{ old('location', $settings->location) }}" placeholder="Gaborone, Botswana">
                </div>
            </div>

            {{-- Social Links --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="ti ti-share"></i> Social Links</div>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="ti ti-brand-linkedin"></i> LinkedIn URL</label>
                    <input type="url" name="linkedin_url" class="form-input" value="{{ old('linkedin_url', $settings->linkedin_url) }}" placeholder="https://linkedin.com/in/...">
                    @error('linkedin_url')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="ti ti-brand-behance"></i> Behance URL</label>
                    <input type="url" name="behance_url" class="form-input" value="{{ old('behance_url', $settings->behance_url) }}" placeholder="https://behance.net/...">
                    @error('behance_url')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="ti ti-brand-dribbble"></i> Dribbble URL</label>
                    <input type="url" name="dribbble_url" class="form-input" value="{{ old('dribbble_url', $settings->dribbble_url) }}" placeholder="https://dribbble.com/...">
                    @error('dribbble_url')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="ti ti-brand-github"></i> GitHub URL</label>
                    <input type="url" name="github_url" class="form-input" value="{{ old('github_url', $settings->github_url) }}" placeholder="https://github.com/...">
                    @error('github_url')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>
    </div>

    {{-- SAVE BUTTON --}}
    <div style="margin-top:20px; display:flex; justify-content:flex-end;">
        <button type="submit" class="btn-primary">
            <i class="ti ti-device-floppy"></i> Save Settings
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewFile(input, targetId) {
    const target = document.getElementById(targetId);
    if (input.files && input.files[0]) {
        target.textContent = input.files[0].name;
    }
}
document.getElementById('accent_color').addEventListener('input', function() {
    document.getElementById('color-preview').style.background = this.value;
});
</script>
@endpush