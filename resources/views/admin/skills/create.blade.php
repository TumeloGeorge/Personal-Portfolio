{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/skills/create.blade.php         --}}
{{-- ============================================================ --}}
@extends('admin.layouts.app')
@section('title', 'Add Skill')
@section('subtitle', 'Add a new skill to a category')

@section('content')
<div style="max-width:520px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">New Skill</div>
            <a href="{{ route('admin.skills.index') }}" class="btn-secondary btn-sm">← Back</a>
        </div>

        <form method="POST" action="{{ route('admin.skills.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Category <span class="required">*</span></label>
                <select name="skill_category_id" class="form-select" required>
                    <option value="">— Select category —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('skill_category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('skill_category_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Skill Name <span class="required">*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="e.g. Figma" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Display Level</label>
                <select name="level" class="form-select">
                    <option value="primary"   {{ old('level') === 'primary'   ? 'selected' : '' }}>Primary (highlighted chip)</option>
                    <option value="secondary" {{ old('level') === 'secondary' ? 'selected' : '' }}>Secondary (muted chip)</option>
                </select>
                <div class="form-hint">Primary = electric blue chip. Secondary = grey chip.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}" min="0" style="width:100px;">
                <div class="form-hint">Lower number = appears first.</div>
            </div>

            <div style="display:flex; gap:10px; margin-top:8px;">
                <button type="submit" class="btn-primary"><i class="ti ti-plus"></i> Add Skill</button>
                <a href="{{ route('admin.skills.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection