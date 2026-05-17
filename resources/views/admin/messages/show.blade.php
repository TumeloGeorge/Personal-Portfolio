@extends('admin.layouts.app')
@section('title', 'Message')
@section('subtitle', 'From {{ $message->name }}')

@section('content')
<div style="max-width:680px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">{{ $message->subject ?? '(No subject)' }}</div>
                <div style="font-size:12px; color:#94a3b8; margin-top:3px;">
                    Received {{ $message->created_at->format('d M Y, H:i') }}
                </div>
            </div>
            <a href="{{ route('admin.messages.index') }}" class="btn-secondary btn-sm">← Back</a>
        </div>

        {{-- Sender Info --}}
        <div style="display:flex; gap:12px; align-items:center; padding:16px; background:#f8fafc; border-radius:10px; margin-bottom:20px;">
            <div style="width:44px; height:44px; border-radius:50%; background:rgba(56,189,248,0.1); display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:600; color:#38bdf8; flex-shrink:0;">
                {{ strtoupper(substr($message->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-weight:600; color:#1e293b;">{{ $message->name }}</div>
                <a href="mailto:{{ $message->email }}" style="font-size:13px; color:#38bdf8;">{{ $message->email }}</a>
            </div>
        </div>

        {{-- Message Body --}}
        <div style="font-size:14px; color:#374151; line-height:1.8; white-space:pre-wrap; padding:4px 0;">{{ $message->message }}</div>

        {{-- Actions --}}
        <div style="display:flex; gap:10px; margin-top:28px; padding-top:16px; border-top:1px solid #f1f5f9;">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn-primary">
                <i class="ti ti-mail-forward"></i> Reply via Email
            </a>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                  onsubmit="return confirm('Delete this message permanently?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="ti ti-trash"></i> Delete
                </button>
            </form>
            <a href="{{ route('admin.messages.index') }}" class="btn-secondary">← All Messages</a>
        </div>
    </div>
</div>
@endsection