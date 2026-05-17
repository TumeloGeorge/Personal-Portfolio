@extends('admin.layouts.app')
@section('title', 'Work Experience')
@section('subtitle', 'Manage your career timeline')

@section('topbar-actions')
    <a href="{{ route('admin.experiences.create') }}" class="btn-primary">
        <i class="ti ti-plus"></i> Add Experience
    </a>
@endsection

@section('content')
<div class="card">
    @if($experiences->isEmpty())
        <div style="text-align:center; padding:48px;">
            <i class="ti ti-briefcase" style="font-size:40px; color:#cbd5e1;"></i>
            <p style="margin-top:12px; color:#94a3b8;">No work experience added yet.</p>
            <a href="{{ route('admin.experiences.create') }}" class="btn-primary" style="margin-top:16px; display:inline-flex;">
                <i class="ti ti-plus"></i> Add First Entry
            </a>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Company</th>
                    <th>Period</th>
                    <th>Order</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($experiences as $exp)
                <tr>
                    <td style="font-weight:500; color:#1e293b;">{{ $exp->job_title }}</td>
                    <td style="color:#38bdf8;">{{ $exp->company }}</td>
                    <td style="color:#94a3b8; font-size:12px;">{{ $exp->year_range }}</td>
                    <td style="color:#94a3b8;">{{ $exp->sort_order }}</td>
                    <td style="text-align:right;">
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <a href="{{ route('admin.experiences.edit', $exp) }}" class="btn-secondary btn-sm">
                                <i class="ti ti-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.experiences.destroy', $exp) }}"
                                  onsubmit="return confirm('Delete this experience entry?')">
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