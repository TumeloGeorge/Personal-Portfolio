@extends('admin.layouts.app')
@section('title', 'Edit Project')

@section('content')
<div style="max-width:680px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Edit: {{ $project->title }}</div>
            <a href="{{ route('admin.projects.index') }}" class="btn-secondary btn-sm">← Back</a>
        </div>

        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Project Title <span class="required">*</span></label>
                <input type="text" name="title" class="form-input" value="{{ old('title', $project->title) }}" required>
                @error('title')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description <span class="required">*</span></label>
                <textarea name="description" class="form-textarea" rows="4" required>{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Category <span class="required">*</span></label>
                    <input type="text" name="category" class="form-input" value="{{ old('category', $project->category) }}"
                           list="cat-suggestions" required>
                    <datalist id="cat-suggestions">
                        <option value="UI/UX">
                        <option value="Branding">
                        <option value="Mobile">
                        <option value="Web">
                        <option value="Print">
                    </datalist>
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $project->sort_order) }}" min="0">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Thumbnail Image</label>
                @if($project->thumbnail_path)
                    <div style="margin-bottom:10px;">
                        <img src="{{ Storage::url($project->thumbnail_path) }}"
                             style="max-height:120px; border-radius:8px; border:1px solid #e2e8f0;">
                    </div>
                @endif
                <div class="file-upload" onclick="document.getElementById('thumb').click()">
                    <input type="file" id="thumb" name="thumbnail" accept="image/*" onchange="previewThumb(this)">
                    <i class="ti ti-photo"></i>
                    <p>Upload new image to replace current</p>
                    <div class="filename" id="thumb-name"></div>
                </div>
                <div id="thumb-preview-wrap" style="display:none; margin-top:10px;">
                    <img id="thumb-preview" style="max-height:120px; border-radius:8px; border:1px solid #e2e8f0;">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Project URL</label>
                    <input type="url" name="project_url" class="form-input" value="{{ old('project_url', $project->project_url) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Case Study URL</label>
                    <input type="url" name="case_study_url" class="form-input" value="{{ old('case_study_url', $project->case_study_url) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                    <input type="hidden" name="featured" value="0">
                    <input type="checkbox" name="featured" value="1" {{ old('featured', $project->featured) ? 'checked' : '' }}
                           style="width:16px; height:16px; accent-color:#38bdf8;">
                    Mark as Featured
                </label>
            </div>

            <div style="display:flex; gap:10px; margin-top:8px;">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i> Save Changes</button>
                <a href="{{ route('admin.projects.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
function previewThumb(input) {
    document.getElementById('thumb-name').textContent = input.files[0]?.name || '';
    if (input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('thumb-preview').src = e.target.result;
            document.getElementById('thumb-preview-wrap').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush