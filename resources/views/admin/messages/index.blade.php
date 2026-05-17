@extends('admin.layouts.app')
@section('title', 'Messages')
@section('subtitle', 'Contact form submissions from your portfolio')

@section('content')
<div class="card">
    @if($messages->isEmpty())
        <div style="text-align:center; padding:48px;">
            <i class="ti ti-mail-opened" style="font-size:40px; color:#cbd5e1;"></i>
            <p style="margin-top:12px; color:#94a3b8;">No messages yet.</p>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Received</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                <tr style="{{ $msg->isUnread() ? 'background:#fafbff;' : '' }}">
                    <td>
                        @if($msg->isUnread())
                            <span class="tag tag-blue"><i class="ti ti-mail"></i> Unread</span>
                        @else
                            <span class="tag tag-gray">Read</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:{{ $msg->isUnread() ? '600' : '400' }}; color:#1e293b;">{{ $msg->name }}</div>
                        <div style="font-size:11px; color:#94a3b8;">{{ $msg->email }}</div>
                    </td>
                    <td style="color:#374151;">{{ $msg->subject ?? '(No subject)' }}</td>
                    <td style="font-size:12px; color:#94a3b8;">{{ $msg->created_at->diffForHumans() }}</td>
                    <td style="text-align:right;">
                        <div style="display:flex; gap:6px; justify-content:flex-end;">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="btn-secondary btn-sm">
                                <i class="ti ti-eye"></i> Open
                            </a>
                            <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}"
                                  onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm"><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:16px;">{{ $messages->links() }}</div>
    @endif
</div>
@endsection