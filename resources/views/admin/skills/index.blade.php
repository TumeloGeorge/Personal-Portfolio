@extends('admin.layouts.app')
@section('title', 'Skills')
@section('subtitle', 'Manage your skill categories and individual skills')

@section('topbar-actions')
    <a href="{{ route('admin.skills.categories.create') }}" class="btn-secondary btn-sm">
        <i class="ti ti-folder-plus"></i> Add Category
    </a>
    <a href="{{ route('admin.skills.create') }}" class="btn-primary">
        <i class="ti ti-plus"></i> Add Skill
    </a>
@endsection

@section('content')
@foreach($categories as $category)
<div class="card" style="margin-bottom:16px;">
    <div class="card-header">
        <div style="display:flex; align-items:center; gap:10px;">
            @if($category->icon)
                <i class="ti {{ $category->icon }}" style="font-size:18px; color:#38bdf8;"></i>
            @endif
            <div class="card-title">{{ $category->name }}</div>
            <span class="tag tag-gray">{{ $category->skills->count() }} skills</span>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('admin.skills.categories.edit', $category) }}" class="btn-secondary btn-sm">
                <i class="ti ti-edit"></i> Edit Category
            </a>
            <form method="POST" action="{{ route('admin.skills.categories.destroy', $category) }}"
                  onsubmit="return confirm('Delete this category and ALL its skills?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger btn-sm"><i class="ti ti-trash"></i></button>
            </form>
        </div>
    </div>

    @if($category->skills->isEmpty())
        <p style="font-size:13px; color:#94a3b8; padding:8px 0;">No skills yet in this category.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Skill Name</th>
                    <th>Level</th>
                    <th>Order</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category->skills as $skill)
                <tr>
                    <td style="font-weight:500;">{{ $skill->name }}</td>
                    <td>
                        @if($skill->level === 'primary')
                            <span class="tag tag-blue">Primary</span>
                        @else
                            <span class="tag tag-gray">Secondary</span>
                        @endif
                    </td>
                    <td style="color:#94a3b8;">{{ $skill->sort_order }}</td>
                    <td style="text-align:right;">
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <a href="{{ route('admin.skills.edit', $skill) }}" class="btn-secondary btn-sm">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}"
                                  onsubmit="return confirm('Delete this skill?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm"><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endforeach

@if($categories->isEmpty())
    <div class="card" style="text-align:center; padding:48px;">
        <i class="ti ti-code" style="font-size:40px; color:#cbd5e1;"></i>
        <p style="margin-top:12px; color:#94a3b8;">No skill categories yet. Add one to get started.</p>
        <a href="{{ route('admin.skills.categories.create') }}" class="btn-primary" style="margin-top:16px; display:inline-flex;">
            <i class="ti ti-plus"></i> Add First Category
        </a>
    </div>
@endif
@endsection