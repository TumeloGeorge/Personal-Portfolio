@extends('admin.layouts.app')
@section('title', 'Add Skill Category')

@section('content')
<div style="max-width:520px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">New Category</div>
            <a href="{{ route('admin.skills.index') }}" class="btn-secondary btn-sm">← Back</a>
        </div>

        <form method="POST" action="{{ route('admin.skills.categories.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="category_name">Category Name <span class="required">*</span></label>
                <input type="text" id="category_name" name="name" class="form-input" value="{{ old('name') }}" placeholder="e.g. UI/UX Design" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="category_icon">Icon Class</label>
                <input type="text" id="category_icon" name="icon" class="form-input" value="{{ old('icon') }}" placeholder="e.g. ti-layout">
                <div class="form-hint">
                    Use a <a href="https://tabler.io/icons" target="_blank" style="color:#38bdf8;">Tabler Icons</a> name e.g. <code>ti-palette</code>, <code>ti-code</code>.
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="category_sort_order">Sort Order</label>
                <input type="number" id="category_sort_order" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}" min="0" style="width:100px;">
            </div>

            <div style="display:flex; gap:10px; margin-top:8px;">
                <button type="submit" class="btn-primary"><i class="ti ti-plus"></i> Add Category</button>
                <a href="{{ route('admin.skills.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection