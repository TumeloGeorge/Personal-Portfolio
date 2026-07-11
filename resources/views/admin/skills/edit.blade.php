@extends('admin.layouts.app')
@section('title', 'Edit Skill')
@section('subtitle', 'Update skill details')

@section('content')
<div style="max-width:520px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Edit: {{ $skill->name }}</div>
            <a href="{{ route('admin.skills.index') }}" class="btn-secondary btn-sm">← Back</a>
        </div>

        <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label" for="skill_category_id">Category <span class="required">*</span></label>
                <select id="skill_category_id" name="skill_category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('skill_category_id', $skill->skill_category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('skill_category_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="skill_name">Skill Name <span class="required">*</span></label>
                <input type="text" id="skill_name" name="name" class="form-input" value="{{ old('name', $skill->name) }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="skill_level">Display Level</label>
                <select id="skill_level" name="level" class="form-select">
                    <option value="primary"   {{ old('level', $skill->level) === 'primary'   ? 'selected' : '' }}>Primary (highlighted chip)</option>
                    <option value="secondary" {{ old('level', $skill->level) === 'secondary' ? 'selected' : '' }}>Secondary (muted chip)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="skill_sort_order">Sort Order</label>
                <input type="number" id="skill_sort_order" name="sort_order" class="form-input" value="{{ old('sort_order', $skill->sort_order) }}" min="0" style="width:100px;">
            </div>

            <div style="display:flex; gap:10px; margin-top:8px;">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i> Save Changes</button>
                <a href="{{ route('admin.skills.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection