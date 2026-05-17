@extends('admin.layouts.app')
@section('title', 'Edit Certification')

@section('content')
<div style="max-width:640px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Edit: {{ $certification->name }}</div>
            <a href="{{ route('admin.certifications.index') }}" class="btn-secondary btn-sm">← Back</a>
        </div>

        <form method="POST" action="{{ route('admin.certifications.update', $certification) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Certification Name <span class="required">*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $certification->name) }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Issuing Body <span class="required">*</span></label>
                    <input type="text" name="issuing_body" class="form-input" value="{{ old('issuing_body', $certification->issuing_body) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Year <span class="required">*</span></label>
                    <input type="number" name="year" class="form-input" value="{{ old('year', $certification->year) }}" min="1900" max="2099" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Credential URL</label>
                <input type="url" name="credential_url" class="form-input" value="{{ old('credential_url', $certification->credential_url) }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Replace Certificate File</label>
                    @if($certification->certificate_file_path)
                        <div style="margin-bottom:8px; font-size:12px; color:#64748b; display:flex; align-items:center; gap:6px;">
                            <i class="ti ti-file" style="color:#38bdf8;"></i>
                            <a href="{{ Storage::url($certification->certificate_file_path) }}" target="_blank" style="color:#38bdf8;">Current file</a>
                        </div>
                    @endif
                    <div class="file-upload" onclick="document.getElementById('cert_file').click()">
                        <input type="file" id="cert_file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png"
                               onchange="previewFile(this,'cert-preview')">
                        <i class="ti ti-upload"></i>
                        <p>Upload new file to replace</p>
                        <div class="filename" id="cert-preview"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Replace Badge Image</label>
                    @if($certification->badge_image_path)
                        <div style="margin-bottom:8px;">
                            <img src="{{ Storage::url($certification->badge_image_path) }}" class="img-preview">
                        </div>
                    @endif
                    <div class="file-upload" onclick="document.getElementById('badge_img').click()">
                        <input type="file" id="badge_img" name="badge_image" accept="image/*"
                               onchange="previewFile(this,'badge-preview')">
                        <i class="ti ti-photo"></i>
                        <p>Upload new image to replace</p>
                        <div class="filename" id="badge-preview"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $certification->sort_order) }}" min="0" style="width:100px;">
            </div>

            <div style="display:flex; gap:10px; margin-top:8px;">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i> Save Changes</button>
                <a href="{{ route('admin.certifications.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
function previewFile(input, id) {
    const el = document.getElementById(id);
    if (input.files[0]) el.textContent = input.files[0].name;
}
</script>
@endpush