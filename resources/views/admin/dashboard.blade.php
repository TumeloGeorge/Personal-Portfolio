@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('subtitle', 'Welcome back — here\'s what\'s happening')

@section('content')

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="ti ti-layout-grid"></i></div>
        <div>
            <div class="stat-num">{{ $stats['projects'] }}</div>
            <div class="stat-label">Projects</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="ti ti-certificate"></i></div>
        <div>
            <div class="stat-num">{{ $stats['certifications'] }}</div>
            <div class="stat-label">Certifications</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="ti ti-briefcase"></i></div>
        <div>
            <div class="stat-num">{{ $stats['experiences'] }}</div>
            <div class="stat-label">Work Experiences</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="ti ti-mail"></i></div>
        <div>
            <div class="stat-num">{{ $stats['unread_messages'] }}</div>
            <div class="stat-label">Unread Messages</div>
        </div>
    </div>
</div>

{{-- RECENT MESSAGES --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">Recent Messages</div>
        <a href="{{ route('admin.messages.index') }}" class="btn-secondary btn-sm">View All</a>
    </div>

    @if($recentMessages->isEmpty())
        <p style="font-size:13px; color:#94a3b8; text-align:center; padding:24px 0;">No messages yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Received</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentMessages as $msg)
                <tr>
                    <td>
                        <div style="font-weight:500; color:#1e293b;">{{ $msg->name }}</div>
                        <div style="font-size:11px; color:#94a3b8;">{{ $msg->email }}</div>
                    </td>
                    <td style="color:#374151;">{{ $msg->subject ?? '(No subject)' }}</td>
                    <td style="color:#94a3b8; font-size:12px;">{{ $msg->created_at->diffForHumans() }}</td>
                    <td>
                        @if($msg->isUnread())
                            <span class="tag tag-blue">Unread</span>
                        @else
                            <span class="tag tag-gray">Read</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.messages.show', $msg) }}" class="btn-secondary btn-sm">Open</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection