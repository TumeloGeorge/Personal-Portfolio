@extends('admin.layouts.app')
@section('title', 'Projects')
@section('subtitle', 'Manage your portfolio projects')

@section('topbar-actions')
    <a href="{{ route('admin.projects.create') }}" class="btn-primary">
        <i class="ti ti-plus"></i> Add Project
    </a>
@endsection

@section('content')
<div class="card">
    @if($projects->isEmpty())
        <div style="text-align:center; padding:48px;">
            <i class="ti ti-layout-grid" style="font-size:40px; color:#cbd5e1;"></i>
            <p style="margin-top:12px; color:#94a3b8;">No projects added yet.</p>
            <a href="{{ route('admin.projects.create') }}" class="btn-primary" style="margin-top:16px; display:inline-flex;">
                <i class="ti ti-plus"></i> Add First Project
            </a>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Order</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>
                        @if($project->thumbnail_path)
                            <img src="{{ Storage::url($project->thumbnail_path) }}"
                                 style="width:56px; height:40px; border-radius:6px; object-fit:cover; border:1px solid #e2e8f0;">
                        @else
                            <div style="width:56px; height:40px; border-radius:6px; background:#f1f5f9; display:flex; align-items:center; justify-content:center;">
                                <i class="ti ti-photo" style="color:#94a3b8;"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:500;">{{ $project->title }}</td>
                    <td><span class="tag tag-blue">{{ $project->category }}</span></td>
                    <td>
                        @if($project->featured)
                            <span class="tag tag-green"><i class="ti ti-star-filled"></i> Featured</span>
                        @else
                            <span class="tag tag-gray">No</span>
                        @endif
                    </td>
                    <td style="color:#94a3b8;">{{ $project->sort_order }}</td>
                    <td style="text-align:right;">
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn-secondary btn-sm">
                                <i class="ti ti-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                                  onsubmit="return confirm('Delete this project?')">
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
@endsection