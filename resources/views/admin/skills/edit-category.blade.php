@extends('admin.layouts.app')
@section('title', 'Edit Category')

@section('content')
<div style="max-width:520px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Edit: {{ $category->name }}</div>
            <a href="{{ route('admin.skills.index') }}" class="btn-secondary btn-sm">← Back</a>
        </div>

        <form method="POST" action="{{ route('admin.skills.categories.update', $category) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Category Name <span class="required">*</span></label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $category->name) }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Icon Class</label>
                <input type="text" name="icon" class="form-input" value="{{ old('icon', $category->icon) }}" placeholder="e.g. ti-layout">
                <div class="form-hint">
                    Use a <a href="https://tabler.io/icons" target="_blank" style="color:#38bdf8;">Tabler Icons</a> name.
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $category->sort_order) }}" min="0" style="width:100px;">
            </div>

            <div style="display:flex; gap:10px; margin-top:8px;">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i> Save</button>
                <a href="{{ route('admin.skills.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection