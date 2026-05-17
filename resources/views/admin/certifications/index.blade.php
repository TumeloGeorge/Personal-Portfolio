@extends('admin.layouts.app')
@section('title', 'Certifications')
@section('subtitle', 'Manage your certificates and credentials')

@section('topbar-actions')
    <a href="{{ route('admin.certifications.create') }}" class="btn-primary">
        <i class="ti ti-plus"></i> Add Certification
    </a>
@endsection

@section('content')
<div class="card">
    @if($certifications->isEmpty())
        <div style="text-align:center; padding:48px;">
            <i class="ti ti-certificate" style="font-size:40px; color:#cbd5e1;"></i>
            <p style="margin-top:12px; color:#94a3b8;">No certifications added yet.</p>
            <a href="{{ route('admin.certifications.create') }}" class="btn-primary" style="margin-top:16px; display:inline-flex;">
                <i class="ti ti-plus"></i> Add First Certification
            </a>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Badge</th>
                    <th>Certification</th>
                    <th>Issuing Body</th>
                    <th>Year</th>
                    <th>Certificate</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($certifications as $cert)
                <tr>
                    <td>
                        @if($cert->badge_image_path)
                            <img src="{{ Storage::url($cert->badge_image_path) }}" style="width:36px;height:36px;border-radius:6px;object-fit:cover;">
                        @else
                            <div style="width:36px;height:36px;border-radius:6px;background:rgba(56,189,248,0.1);display:flex;align-items:center;justify-content:center;">
                                <i class="ti ti-certificate" style="color:#38bdf8;font-size:18px;"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:500;">{{ $cert->name }}</td>
                    <td style="color:#64748b;">{{ $cert->issuing_body }}</td>
                    <td><span class="tag tag-blue">{{ $cert->year }}</span></td>
                    <td>
                        @if($cert->certificate_file_path)
                            <a href="{{ Storage::url($cert->certificate_file_path) }}" target="_blank" class="btn-secondary btn-sm">
                                <i class="ti ti-eye"></i> View
                            </a>
                        @else
                            <span style="font-size:12px; color:#94a3b8;">No file</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <a href="{{ route('admin.certifications.edit', $cert) }}" class="btn-secondary btn-sm">
                                <i class="ti ti-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.certifications.destroy', $cert) }}"
                                  onsubmit="return confirm('Delete this certification?')">
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