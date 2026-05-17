@extends('admin.layouts.app')
@section('title', 'Add Certification')

@section('content')
<div style="max-width:640px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">New Certification</div>
            <a href="{{ route('admin.certifications.index') }}" class="btn-secondary btn-sm">← Back</a>
        </div>

        <form method="POST" action="{{ route('admin.certifications.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Certification Name <span class="required">*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="e.g. Google UX Design Certificate" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Issuing Body <span class="required">*</span></label>
                    <input type="text" name="issuing_body" class="form-input" value="{{ old('issuing_body') }}" placeholder="e.g. Google / Coursera" required>
                    @error('issuing_body')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Year <span class="required">*</span></label>
                    <input type="number" name="year" class="form-input" value="{{ old('year', date('Y')) }}" min="1900" max="2099" required>
                    @error('year')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Credential URL</label>
                <input type="url" name="credential_url" class="form-input" value="{{ old('credential_url') }}" placeholder="https://...">
                <div class="form-hint">Optional link to verify the certificate online.</div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Certificate File</label>
                    <div class="file-upload" onclick="document.getElementById('cert_file').click()">
                        <input type="file" id="cert_file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png"
                               onchange="previewFile(this,'cert-preview')">
                        <i class="ti ti-upload"></i>
                        <p>PDF or image (max 5MB)</p>
                        <div class="filename" id="cert-preview"></div>
                    </div>
                    @error('certificate_file')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Badge / Logo Image</label>
                    <div class="file-upload" onclick="document.getElementById('badge_img').click()">
                        <input type="file" id="badge_img" name="badge_image" accept="image/*"
                               onchange="previewFile(this,'badge-preview')">
                        <i class="ti ti-photo"></i>
                        <p>PNG or JPG (max 2MB)</p>
                        <div class="filename" id="badge-preview"></div>
                    </div>
                    @error('badge_image')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}" min="0" style="width:100px;">
            </div>

            <div style="display:flex; gap:10px; margin-top:8px;">
                <button type="submit" class="btn-primary"><i class="ti ti-plus"></i> Add Certification</button>
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