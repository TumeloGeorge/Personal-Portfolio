@extends('admin.layouts.app')
@section('title', 'Hero Section')
@section('subtitle', 'Edit the main banner that visitors see first')

@section('content')
<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

    <div>
        <form method="POST" action="{{ route('admin.hero.update') }}">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="ti ti-home"></i> Hero Content</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Headline (Your Name) <span class="required">*</span></label>
                    <input type="text" name="headline" class="form-input" value="{{ old('headline', $hero->headline) }}" required>
                    @error('headline')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Subheadline (Role Title) <span class="required">*</span></label>
                    <input type="text" name="subheadline" class="form-input" value="{{ old('subheadline', $hero->subheadline) }}" placeholder="e.g. UI/UX & Graphic Designer" required>
                    @error('subheadline')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Bio Paragraph <span class="required">*</span></label>
                    <textarea name="bio" class="form-textarea" rows="4" required>{{ old('bio', $hero->bio) }}</textarea>
                    @error('bio')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Primary CTA Label</label>
                        <input type="text" name="cta_primary_label" class="form-input" value="{{ old('cta_primary_label', $hero->cta_primary_label) }}" placeholder="View Projects">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Secondary CTA Label</label>
                        <input type="text" name="cta_secondary_label" class="form-input" value="{{ old('cta_secondary_label', $hero->cta_secondary_label) }}" placeholder="Download CV">
                    </div>
                </div>

                <div style="border-top:1px solid #f1f5f9; padding-top:16px; margin-top:4px;">
                    <div class="card-title" style="margin-bottom:14px; font-size:13px;">Stats</div>
                    <div class="form-row" style="grid-template-columns:1fr 1fr 1fr;">
                        <div class="form-group">
                            <label class="form-label">Projects Count</label>
                            <input type="number" name="projects_count" class="form-input" value="{{ old('projects_count', $hero->projects_count) }}" min="0">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Years Experience</label>
                            <input type="number" name="years_experience" class="form-input" value="{{ old('years_experience', $hero->years_experience) }}" min="0">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Clients Count</label>
                            <input type="number" name="clients_count" class="form-input" value="{{ old('clients_count', $hero->clients_count) }}" min="0">
                        </div>
                    </div>
                </div>

                <div style="margin-top:8px;">
                    <button type="submit" class="btn-primary">
                        <i class="ti ti-device-floppy"></i> Save Hero Section
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- LIVE PREVIEW --}}
    <div class="card" style="background:#0a0c10; border-color:#1a2035;">
        <div class="card-header" style="border-color:#1a2035;">
            <div class="card-title" style="color:#94a3b8; font-size:12px;">LIVE PREVIEW</div>
        </div>
        <div style="padding:8px 0;">
            <div style="display:inline-flex; align-items:center; gap:6px; background:rgba(56,189,248,0.1); border:1px solid rgba(56,189,248,0.25); border-radius:20px; padding:4px 12px; font-size:11px; color:#38bdf8; margin-bottom:14px;">
                <span style="width:6px;height:6px;background:#38bdf8;border-radius:50%;display:inline-block;"></span>
                Available for work
            </div>
            <div id="prev-headline" style="font-size:28px; font-weight:500; color:#f1f5f9; line-height:1.2;">{{ $hero->headline }}</div>
            <div id="prev-subheadline" style="font-size:15px; color:#38bdf8; margin:6px 0 10px;">{{ $hero->subheadline }}</div>
            <div id="prev-bio" style="font-size:12px; color:#64748b; line-height:1.7; margin-bottom:18px;">{{ $hero->bio }}</div>
            <div style="display:flex; gap:10px; margin-bottom:20px;">
                <div style="background:#38bdf8; color:#0a0c10; font-size:11px; font-weight:500; padding:8px 16px; border-radius:6px;" id="prev-cta1">{{ $hero->cta_primary_label }}</div>
                <div style="border:1px solid #38bdf8; color:#38bdf8; font-size:11px; padding:8px 16px; border-radius:6px;" id="prev-cta2">{{ $hero->cta_secondary_label }}</div>
            </div>
            <div style="display:flex; gap:16px;">
                <div style="text-align:center;">
                    <div style="font-size:18px; font-weight:500; color:#38bdf8;" id="prev-proj">{{ $hero->projects_count }}+</div>
                    <div style="font-size:10px; color:#475569;">Projects</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:18px; font-weight:500; color:#38bdf8;" id="prev-exp">{{ $hero->years_experience }} yrs</div>
                    <div style="font-size:10px; color:#475569;">Experience</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:18px; font-weight:500; color:#38bdf8;" id="prev-cli">{{ $hero->clients_count }}+</div>
                    <div style="font-size:10px; color:#475569;">Clients</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const bindings = [
    ['headline',            'prev-headline'],
    ['subheadline',         'prev-subheadline'],
    ['bio',                 'prev-bio'],
    ['cta_primary_label',   'prev-cta1'],
    ['cta_secondary_label', 'prev-cta2'],
];
bindings.forEach(([name, id]) => {
    const input = document.querySelector(`[name="${name}"]`);
    const preview = document.getElementById(id);
    if (input && preview) {
        input.addEventListener('input', () => preview.textContent = input.value);
    }
});
document.querySelector('[name="projects_count"]').addEventListener('input', e => {
    document.getElementById('prev-proj').textContent = e.target.value + '+';
});
document.querySelector('[name="years_experience"]').addEventListener('input', e => {
    document.getElementById('prev-exp').textContent = e.target.value + ' yrs';
});
document.querySelector('[name="clients_count"]').addEventListener('input', e => {
    document.getElementById('prev-cli').textContent = e.target.value + '+';
});
</script>
@endpush