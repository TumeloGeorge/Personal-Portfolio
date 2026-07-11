@extends('admin.layouts.app')
@section('title', 'Edit Experience')

@section('content')
<div style="max-width:620px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Edit: {{ $experience->job_title }}</div>
            <a href="{{ route('admin.experiences.index') }}" class="btn-secondary btn-sm">← Back</a>
        </div>

        <form method="POST" action="{{ route('admin.experiences.update', $experience) }}">
            @csrf @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="job_title">Job Title <span class="required">*</span></label>
                    <input type="text" id="job_title" name="job_title" class="form-input" value="{{ old('job_title', $experience->job_title) }}" required>
                    @error('job_title')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="company">Company <span class="required">*</span></label>
                    <input type="text" id="company" name="company" class="form-input" value="{{ old('company', $experience->company) }}" required>
                    @error('company')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="start_year">Start Year <span class="required">*</span></label>
                    <input type="number" id="start_year" name="start_year" class="form-input" value="{{ old('start_year', $experience->start_year) }}" min="1900" max="2099" required>
                    @error('start_year')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="end_year">End Year</label>
                    <input type="number" id="end_year" name="end_year" class="form-input" value="{{ old('end_year', $experience->end_year) }}" min="1900" max="2099">
                    <div class="form-hint">Leave blank to show "Present"</div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="experience_description">Description <span class="required">*</span></label>
                <textarea id="experience_description" name="description" class="form-textarea" rows="4" required>{{ old('description', $experience->description) }}</textarea>
                @error('description')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="experience_sort_order">Sort Order</label>
                <input type="number" id="experience_sort_order" name="sort_order" class="form-input" value="{{ old('sort_order', $experience->sort_order) }}" min="0" style="width:100px;">
            </div>

            <div style="display:flex; gap:10px; margin-top:8px;">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i> Save Changes</button>
                <a href="{{ route('admin.experiences.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection