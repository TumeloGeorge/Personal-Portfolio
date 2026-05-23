<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->full_name }} — {{ $settings->role_title }}</title>
    <meta name="description" content="{{ $settings->short_bio }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        :root {
            --accent: {{ $settings->accent_color ?? '#38bdf8' }};
            --accent-dim: {{ $settings->accent_color ?? '#38bdf8' }}18;
            --accent-border: {{ $settings->accent_color ?? '#38bdf8' }}40;
            --bg: #0a0c10;
            --surface: #0f1520;
            --surface2: #131825;
            --border: #1a2035;
            --text: #e2e8f0;
            --muted: #64748b;
            --dim: #475569;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; }

        /* ── NAV ── */
        .nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 48px;
            background: rgba(10,12,16,0.85); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .nav-logo { font-size: 16px; font-weight: 600; color: var(--accent); letter-spacing: 0.04em; }
        .nav-links { display: flex; gap: 28px; }
        .nav-link { font-size: 13px; color: var(--muted); transition: color 0.2s; }
        .nav-link:hover, .nav-link.active { color: var(--accent); }
        .nav-cta {
            background: var(--accent); color: #0a0c10;
            font-size: 12px; font-weight: 600; padding: 8px 20px; border-radius: 8px;
            transition: opacity 0.2s;
        }
        .nav-cta:hover { opacity: 0.88; }

        /* ── SECTIONS ── */
        section { padding: 96px 48px; border-bottom: 1px solid var(--border); position: relative; }
        .section-num {
            position: absolute; right: 48px; top: 64px;
            font-size: 80px; font-weight: 700;
            color: rgba(255,255,255,0.02); line-height: 1; pointer-events: none; user-select: none;
        }
        .section-label { font-size: 11px; color: var(--accent); letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 8px; }
        .section-title { font-size: 28px; font-weight: 500; color: #f1f5f9; margin-bottom: 6px; }
        .section-sub { font-size: 14px; color: var(--muted); margin-bottom: 40px; }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

        /* ── HERO ── */
        #hero {
            min-height: 100vh; display: flex; align-items: center;
            padding-top: 100px; border-bottom: 1px solid var(--border);
            overflow: hidden; position: relative;
        }
        .hero-glow {
            position: absolute; top: -100px; right: -100px;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, var(--accent-dim) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-grid { display: grid; grid-template-columns: 1fr auto; gap: 64px; align-items: center; width: 100%; }
        .hero-tag {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--accent-dim); border: 1px solid var(--accent-border);
            border-radius: 20px; padding: 5px 14px; font-size: 12px; color: var(--accent);
            margin-bottom: 20px;
        }
        .hero-tag-dot { width: 7px; height: 7px; background: var(--accent); border-radius: 50%; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        .hero-name { font-size: 52px; font-weight: 500; line-height: 1.1; color: #f1f5f9; margin-bottom: 8px; }
        .hero-role { font-size: 22px; color: var(--accent); font-weight: 400; margin-bottom: 20px; }
        .hero-bio { font-size: 15px; color: var(--muted); line-height: 1.75; max-width: 480px; margin-bottom: 36px; }
        .hero-btns { display: flex; gap: 14px; margin-bottom: 40px; }
        .btn-primary { background: var(--accent); color: #0a0c10; font-size: 13px; font-weight: 600; padding: 12px 28px; border-radius: 10px; transition: opacity 0.2s; display: inline-flex; align-items: center; gap: 7px; }
        .btn-primary:hover { opacity: 0.88; }
        .btn-outline { border: 1px solid var(--accent); color: var(--accent); font-size: 13px; padding: 12px 28px; border-radius: 10px; transition: background 0.2s; display: inline-flex; align-items: center; gap: 7px; }
        .btn-outline:hover { background: var(--accent-dim); }
        .hero-stats { display: flex; gap: 32px; }
        .stat-num { font-size: 24px; font-weight: 600; color: var(--accent); }
        .stat-label { font-size: 11px; color: var(--dim); margin-top: 3px; }
        .avatar-wrap { position: relative; flex-shrink: 0; }
        .avatar {
            width: 220px; height: 220px; border-radius: 50%;
            background: linear-gradient(135deg, var(--surface), #1e293b);
            border: 2px solid var(--accent-border);
            display: flex; align-items: center; justify-content: center;
            font-size: 48px; font-weight: 600; color: var(--accent);
            overflow: hidden; position: relative;
        }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .avatar-ring {
            position: absolute; inset: -10px; border-radius: 50%;
            border: 1px dashed var(--accent-border);
            animation: spin 20s linear infinite;
        }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .avatar-badge {
            position: absolute; bottom: 12px; right: -8px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 10px; padding: 6px 12px;
            font-size: 11px; color: var(--accent); white-space: nowrap;
        }

        /* ── SKILLS ── */
        .skills-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .skill-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px; }
        .skill-card-icon { font-size: 22px; color: var(--accent); margin-bottom: 10px; }
        .skill-card-title { font-size: 13px; font-weight: 500; color: #94a3b8; margin-bottom: 14px; }
        .chips { display: flex; flex-wrap: wrap; gap: 7px; }
        .chip { font-size: 11px; padding: 4px 12px; border-radius: 14px; }
        .chip-primary { background: var(--accent-dim); border: 1px solid var(--accent-border); color: var(--accent); }
        .chip-secondary { background: var(--surface2); border: 1px solid var(--border); color: var(--dim); }

        /* ── EXPERIENCE ── */
        .timeline { display: flex; flex-direction: column; }
        .timeline-item { display: grid; grid-template-columns: 120px 1fr; gap: 32px; padding: 28px 0; border-bottom: 1px solid var(--surface2); }
        .timeline-item:last-child { border-bottom: none; }
        .timeline-year { font-size: 12px; color: var(--dim); padding-top: 3px; line-height: 1.5; }
        .timeline-dot { width: 8px; height: 8px; background: var(--accent); border-radius: 50%; display: inline-block; margin-right: 8px; vertical-align: middle; flex-shrink: 0; }
        .timeline-role { font-size: 15px; font-weight: 500; color: #e2e8f0; margin-bottom: 4px; }
        .timeline-company { font-size: 13px; color: var(--accent); margin-bottom: 8px; }
        .timeline-desc { font-size: 13px; color: var(--muted); line-height: 1.7; }

        /* ── CERTIFICATIONS ── */
        .certs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .cert-card {
            background: var(--surface); border: 1px solid var(--border); border-radius: 12px;
            padding: 20px; display: flex; gap: 14px; align-items: flex-start;
            transition: border-color 0.2s;
        }
        .cert-card:hover { border-color: var(--accent-border); }
        .cert-icon {
            width: 44px; height: 44px; border-radius: 10px;
            background: var(--accent-dim); display: flex; align-items: center;
            justify-content: center; flex-shrink: 0; overflow: hidden;
        }
        .cert-icon img { width: 100%; height: 100%; object-fit: cover; }
        .cert-icon i { font-size: 22px; color: var(--accent); }
        .cert-name { font-size: 12px; font-weight: 500; color: #cbd5e1; line-height: 1.4; margin-bottom: 3px; }
        .cert-issuer { font-size: 11px; color: var(--dim); }
        .cert-year { font-size: 11px; color: var(--accent); margin-top: 6px; }
        .cert-link { font-size: 10px; color: var(--dim); margin-top: 4px; }
        .cert-link a { color: var(--accent); }

        /* ── PROJECTS ── */
        .projects-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .filter-tabs { display: flex; gap: 0; border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .filter-tab { font-size: 12px; padding: 7px 18px; color: var(--muted); cursor: pointer; transition: all 0.2s; border: none; background: none; font-family: inherit; }
        .filter-tab.active, .filter-tab:hover { background: var(--accent); color: #0a0c10; font-weight: 500; }
        .projects-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .proj-card {
            background: var(--surface); border: 1px solid var(--border); border-radius: 14px;
            overflow: hidden; transition: transform 0.2s, border-color 0.2s; cursor: pointer;
        }
        .proj-card:hover { transform: translateY(-3px); border-color: var(--accent-border); }
        .proj-thumb {
            height: 180px; background: linear-gradient(135deg, var(--surface2), #1a2f4a);
            display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;
        }
        .proj-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .proj-thumb-placeholder { font-size: 11px; color: rgba(255,255,255,0.15); letter-spacing: 0.1em; }
        .proj-cat-tag {
            position: absolute; top: 12px; right: 12px;
            background: var(--accent-dim); border: 1px solid var(--accent-border);
            color: var(--accent); font-size: 10px; padding: 3px 10px; border-radius: 12px;
        }
        .proj-info { padding: 16px; }
        .proj-name { font-size: 14px; font-weight: 500; color: #cbd5e1; margin-bottom: 6px; }
        .proj-desc { font-size: 12px; color: var(--muted); line-height: 1.6; }
        .proj-links { display: flex; gap: 10px; margin-top: 12px; }
        .proj-link { font-size: 11px; color: var(--accent); display: flex; align-items: center; gap: 4px; }
        .carousel-nav { display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 24px; }
        .carousel-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--border); cursor: pointer; transition: all 0.2s; }
        .carousel-dot.active { background: var(--accent); width: 20px; border-radius: 4px; }
        .carousel-arrow { background: var(--surface); border: 1px solid var(--border); color: var(--muted); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 16px; transition: all 0.2s; }
        .carousel-arrow:hover { border-color: var(--accent); color: var(--accent); }

        /* ── CONTACT ── */
        .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; }
        .contact-info { display: flex; flex-direction: column; gap: 20px; }
        .contact-item { display: flex; align-items: center; gap: 14px; }
        .contact-icon { width: 40px; height: 40px; background: var(--accent-dim); border: 1px solid var(--accent-border); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 18px; flex-shrink: 0; }
        .contact-label { font-size: 11px; color: var(--dim); }
        .contact-val { font-size: 13px; color: var(--text); }
        .socials { display: flex; gap: 12px; margin-top: 8px; }
        .social { width: 40px; height: 40px; background: var(--surface); border: 1px solid var(--border); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 18px; transition: all 0.2s; }
        .social:hover { border-color: var(--accent); color: var(--accent); }
        .form-group { margin-bottom: 14px; }
        .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-input, .form-textarea {
            width: 100%; background: var(--surface); border: 1px solid var(--border);
            border-radius: 10px; padding: 11px 14px; font-size: 13px; color: var(--text);
            font-family: inherit; outline: none; transition: border-color 0.2s;
        }
        .form-input::placeholder, .form-textarea::placeholder { color: var(--dim); }
        .form-input:focus, .form-textarea:focus { border-color: var(--accent); }
        .form-textarea { resize: vertical; min-height: 110px; }
        .form-submit { width: 100%; background: var(--accent); color: #0a0c10; font-size: 14px; font-weight: 600; padding: 13px; border-radius: 10px; border: none; cursor: pointer; font-family: inherit; transition: opacity 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .form-submit:hover { opacity: 0.88; }
        .alert-success { background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.25); color: #86efac; border-radius: 10px; padding: 12px 16px; font-size: 13px; margin-bottom: 16px; }

        /* ── FOOTER ── */
        footer { padding: 28px 48px; display: flex; align-items: center; justify-content: space-between; background: #070910; }
        .footer-logo { font-size: 14px; color: var(--accent); font-weight: 600; }
        .footer-copy { font-size: 12px; color: var(--dim); }

        @media (max-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr; gap: 40px; }
            .skills-grid, .certs-grid { grid-template-columns: 1fr; }
            .projects-grid { grid-template-columns: 1fr; }
            .contact-grid { grid-template-columns: 1fr; }
            .timeline-item { grid-template-columns: 1fr; gap: 20px; }
            .timeline-year { padding-top: 0; }
            .projects-header { flex-direction: column; align-items: flex-start; gap: 18px; }
            .filter-tabs { width: 100%; justify-content: flex-start; flex-wrap: wrap; }
            .hero-stats { flex-wrap: wrap; gap: 18px; }
        }

        @media (max-width: 768px) {
            .nav { padding: 14px 16px; flex-wrap: wrap; justify-content: center; gap: 12px; }
            .nav-links {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 12px;
                width: 100%;
            }
            .nav-link { font-size: 12px; }
            .nav-cta { width: 100%; max-width: 260px; justify-content: center; }
            section { padding: 64px 16px; }
            .hero-name { font-size: 38px; }
            .hero-role { font-size: 18px; }
            .hero-bio { max-width: 100%; }
            .hero-btns { flex-direction: column; align-items: stretch; gap: 12px; }
            .btn-primary, .btn-outline { width: 100%; justify-content: center; }
            .hero-stats { flex-direction: column; align-items: stretch; gap: 14px; }
            .avatar-wrap { display: none; }
            .timeline-item { grid-template-columns: 1fr; gap: 16px; }
            .form-row-2 { grid-template-columns: 1fr; }
            footer { flex-direction: column; gap: 8px; text-align: center; }
        }

        @media (max-width: 480px) {
            .nav { padding: 12px 14px; }
            .section-title { font-size: 24px; }
            .section-sub { font-size: 13px; }
            .hero-tag { padding: 6px 12px; }
            .hero-name { font-size: 32px; }
            .hero-role { font-size: 16px; }
            .hero-btns { gap: 10px; }
            .btn-primary, .btn-outline { padding: 12px 16px; font-size: 12px; }
            .skills-grid, .certs-grid { gap: 14px; }
            .proj-card { min-height: auto; }
        }
    </style>
</head>
<body>

{{-- NAV --}}
<nav class="nav">
    <div class="nav-logo">{{ substr($settings->full_name, 0, 2) }}</div>
    <div class="nav-links">
        <a href="#hero"           class="nav-link active">Home</a>
        <a href="#skills"         class="nav-link">Skills</a>
        <a href="#experience"     class="nav-link">Experience</a>
        <a href="#certifications" class="nav-link">Certifications</a>
        <a href="#projects"       class="nav-link">Work</a>
        <a href="#contact"        class="nav-link">Contact</a>
    </div>
    <a href="#contact" class="nav-cta">Hire Me</a>
</nav>

{{-- HERO --}}
<section id="hero">
    <div class="hero-glow"></div>
    <div class="container">
        <div class="hero-grid">
            <div>
                @if($settings->available_for_work)
                    <div class="hero-tag">
                        <span class="hero-tag-dot"></span> Available for work
                    </div>
                @endif
                <h1 class="hero-name">{{ $hero->headline }}</h1>
                <div class="hero-role">{{ $hero->subheadline }}</div>
                <p class="hero-bio">{{ $hero->bio }}</p>
                <div class="hero-btns">
                    <a href="#projects" class="btn-primary">
                        <i class="ti ti-eye"></i> {{ $hero->cta_primary_label }}
                    </a>
                    @if($settings->cv_path)
                        <a href="{{ route('cv.download') }}" class="btn-outline" download>
                            <i class="ti ti-download"></i> {{ $hero->cta_secondary_label }}
                        </a>
                    @else
                        <a href="#contact" class="btn-outline">
                            <i class="ti ti-mail"></i> Get In Touch
                        </a>
                    @endif
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <div class="stat-num">{{ $hero->projects_count }}+</div>
                        <div class="stat-label">Projects</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num">{{ $hero->years_experience }} yrs</div>
                        <div class="stat-label">Experience</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num">{{ $hero->clients_count }}+</div>
                        <div class="stat-label">Clients</div>
                    </div>
                </div>
            </div>
            <div class="avatar-wrap">
                <div class="avatar">
                    @if($settings->avatar_path)
                        <img src="{{ Storage::url($settings->avatar_path) }}" alt="{{ $settings->full_name }}">
                    @else
                        {{ strtoupper(substr($settings->full_name, 0, 2)) }}
                    @endif
                </div>
                <div class="avatar-ring"></div>
                @if($settings->available_for_work)
                    <div class="avatar-badge"><i class="ti ti-circle-filled" style="color:#22c55e; font-size:9px; vertical-align:middle;"></i> Open to work</div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- SKILLS --}}
<section id="skills">
    <div class="section-num">01</div>
    <div class="container">
        <div class="section-label">What I do</div>
        <h2 class="section-title">Skills & Tech Stack</h2>
        <p class="section-sub">Tools and disciplines I use every day</p>
        <div class="skills-grid">
            @foreach($skillCats as $cat)
            <div class="skill-card">
                @if($cat->icon)
                    <div class="skill-card-icon"><i class="ti {{ $cat->icon }}"></i></div>
                @endif
                <div class="skill-card-title">{{ $cat->name }}</div>
                <div class="chips">
                    @foreach($cat->skills as $skill)
                        <span class="chip {{ $skill->level === 'primary' ? 'chip-primary' : 'chip-secondary' }}">
                            {{ $skill->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- EXPERIENCE --}}
<section id="experience">
    <div class="section-num">02</div>
    <div class="container">
        <div class="section-label">My journey</div>
        <h2 class="section-title">Work Experience</h2>
        <p class="section-sub">Places I've crafted great work</p>
        <div class="timeline">
            @foreach($experiences as $exp)
            <div class="timeline-item">
                <div class="timeline-year">{{ $exp->year_range }}</div>
                <div>
                    <div class="timeline-role"><span class="timeline-dot"></span>{{ $exp->job_title }}</div>
                    <div class="timeline-company">{{ $exp->company }}</div>
                    <div class="timeline-desc">{{ $exp->description }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CERTIFICATIONS --}}
<section id="certifications">
    <div class="section-num">03</div>
    <div class="container">
        <div class="section-label">Credentials</div>
        <h2 class="section-title">Certifications</h2>
        <p class="section-sub">Validated skills and formal recognition</p>
        <div class="certs-grid">
            @foreach($certifications as $cert)
            <div class="cert-card">
                <div class="cert-icon">
                    @if($cert->badge_image_path)
                        <img src="{{ Storage::url($cert->badge_image_path) }}" alt="{{ $cert->issuing_body }}">
                    @else
                        <i class="ti ti-certificate"></i>
                    @endif
                </div>
                <div>
                    <div class="cert-name">{{ $cert->name }}</div>
                    <div class="cert-issuer">{{ $cert->issuing_body }}</div>
                    <div class="cert-year">{{ $cert->year }}</div>
                    @if($cert->certificate_file_path || $cert->credential_url)
                        <div class="cert-link">
                            @if($cert->certificate_file_path)
                                <a href="{{ route(certificate.download, $cert) }}" target="_blank">
                                    <i class="ti ti-file-download"></i> View Certificate
                                </a>
                            @elseif($cert->credential_url)
                                <a href="{{ $cert->credential_url }}" target="_blank">
                                    <i class="ti ti-external-link"></i> Verify
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PROJECTS --}}
<section id="projects">
    <div class="section-num">04</div>
    <div class="container">
        <div class="section-label">My portfolio</div>
        <div class="projects-header">
            <div>
                <h2 class="section-title" style="margin-bottom:0;">Featured Projects</h2>
            </div>
            <div class="filter-tabs" id="filter-tabs">
                <button class="filter-tab active" data-filter="all">All</button>
                @foreach($categories as $cat)
                    <button class="filter-tab" data-filter="{{ $cat }}">{{ $cat }}</button>
                @endforeach
            </div>
        </div>

        <div class="projects-grid" id="projects-grid">
            @foreach($projects as $project)
            <div class="proj-card" data-category="{{ $project->category }}">
                <div class="proj-thumb">
                    @if($project->thumbnail_path)
                        <img src="{{ Storage::url($project->thumbnail_path) }}" alt="{{ $project->title }}">
                    @else
                        <div class="proj-thumb-placeholder">PROJECT PREVIEW</div>
                    @endif
                    <span class="proj-cat-tag">{{ $project->category }}</span>
                </div>
                <div class="proj-info">
                    <div class="proj-name">{{ $project->title }}</div>
                    <div class="proj-desc">{{ $project->description }}</div>
                    @if($project->project_url || $project->case_study_url)
                        <div class="proj-links">
                            @if($project->project_url)
                                <a href="{{ $project->project_url }}" target="_blank" class="proj-link">
                                    <i class="ti ti-external-link"></i> View Project
                                </a>
                            @endif
                            @if($project->case_study_url)
                                <a href="{{ $project->case_study_url }}" target="_blank" class="proj-link">
                                    <i class="ti ti-book"></i> Case Study
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="carousel-nav" id="carousel-nav">
            <div class="carousel-arrow" id="prev-btn"><i class="ti ti-chevron-left"></i></div>
            <div id="dots-wrap"></div>
            <div class="carousel-arrow" id="next-btn"><i class="ti ti-chevron-right"></i></div>
        </div>
    </div>
</section>

{{-- CONTACT --}}
<section id="contact">
    <div class="section-num">05</div>
    <div class="container">
        <div class="section-label">Get in touch</div>
        <h2 class="section-title">Contact Me</h2>
        <p class="section-sub">Let's work on something great together</p>
        <div class="contact-grid">

            {{-- Info --}}
            <div class="contact-info">
                @if($settings->email)
                <div class="contact-item">
                    <div class="contact-icon"><i class="ti ti-mail"></i></div>
                    <div>
                        <div class="contact-label">Email</div>
                        <div class="contact-val">{{ $settings->email }}</div>
                    </div>
                </div>
                @endif
                @if($settings->phone)
                <div class="contact-item">
                    <div class="contact-icon"><i class="ti ti-phone"></i></div>
                    <div>
                        <div class="contact-label">Phone</div>
                        <div class="contact-val">{{ $settings->phone }}</div>
                    </div>
                </div>
                @endif
                @if($settings->location)
                <div class="contact-item">
                    <div class="contact-icon"><i class="ti ti-map-pin"></i></div>
                    <div>
                        <div class="contact-label">Location</div>
                        <div class="contact-val">{{ $settings->location }}</div>
                    </div>
                </div>
                @endif

                <div class="socials">
                    @if($settings->linkedin_url)
                        <a href="{{ $settings->linkedin_url }}" target="_blank" class="social"><i class="ti ti-brand-linkedin"></i></a>
                    @endif
                    @if($settings->behance_url)
                        <a href="{{ $settings->behance_url }}" target="_blank" class="social"><i class="ti ti-brand-behance"></i></a>
                    @endif
                    @if($settings->dribbble_url)
                        <a href="{{ $settings->dribbble_url }}" target="_blank" class="social"><i class="ti ti-brand-dribbble"></i></a>
                    @endif
                    @if($settings->github_url)
                        <a href="{{ $settings->github_url }}" target="_blank" class="social"><i class="ti ti-brand-github"></i></a>
                    @endif
                </div>
            </div>

            {{-- Form --}}
            <div>
                @if(session('success'))
                    <div class="alert-success"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="form-row-2">
                        <div class="form-group">
                            <input type="text" name="name" class="form-input" placeholder="Your name"
                                   value="{{ old('name') }}" required>
                            @error('name')<div style="font-size:11px;color:#ef4444;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-input" placeholder="Your email"
                                   value="{{ old('email') }}" required>
                            @error('email')<div style="font-size:11px;color:#ef4444;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" class="form-input" placeholder="Subject"
                               value="{{ old('subject') }}">
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-textarea" placeholder="Your message..." required>{{ old('message') }}</textarea>
                        @error('message')<div style="font-size:11px;color:#ef4444;margin-top:4px;">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="form-submit">
                        <i class="ti ti-send"></i> Send Message
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="footer-logo">{{ $settings->full_name }}</div>
    <div class="footer-copy">© {{ date('Y') }} {{ $settings->full_name }} · All rights reserved</div>
    <div class="socials">
        @if($settings->behance_url)
            <a href="{{ $settings->behance_url }}" target="_blank" class="social"><i class="ti ti-brand-behance"></i></a>
        @endif
        @if($settings->linkedin_url)
            <a href="{{ $settings->linkedin_url }}" target="_blank" class="social"><i class="ti ti-brand-linkedin"></i></a>
        @endif
        @if($settings->dribbble_url)
            <a href="{{ $settings->dribbble_url }}" target="_blank" class="social"><i class="ti ti-brand-dribbble"></i></a>
        @endif
    </div>
</footer>

<script>
// ── Active nav on scroll ──────────────────────────────────────
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-link');
window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(s => { if (window.scrollY >= s.offsetTop - 100) current = s.id; });
    navLinks.forEach(l => {
        l.classList.toggle('active', l.getAttribute('href') === '#' + current);
    });
});

// ── Project filter + carousel ─────────────────────────────────
const cards = [...document.querySelectorAll('.proj-card')];
const grid = document.getElementById('projects-grid');
const dotsWrap = document.getElementById('dots-wrap');
const PAGE = 4; // cards per page
let currentPage = 0;
let filtered = cards;

function renderPage() {
    const totalPages = Math.max(1, Math.ceil(filtered.length / PAGE));
    // hide all
    cards.forEach(c => c.style.display = 'none');
    // show current page
    filtered.slice(currentPage * PAGE, currentPage * PAGE + PAGE)
            .forEach(c => c.style.display = 'block');
    // dots
    dotsWrap.innerHTML = '';
    for (let i = 0; i < totalPages; i++) {
        const d = document.createElement('div');
        d.className = 'carousel-dot' + (i === currentPage ? ' active' : '');
        d.onclick = () => { currentPage = i; renderPage(); };
        dotsWrap.appendChild(d);
    }
}

document.querySelectorAll('.filter-tab').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const f = btn.dataset.filter;
        filtered = f === 'all' ? cards : cards.filter(c => c.dataset.category === f);
        currentPage = 0;
        renderPage();
    });
});

document.getElementById('prev-btn').addEventListener('click', () => {
    const total = Math.ceil(filtered.length / PAGE);
    currentPage = (currentPage - 1 + total) % total;
    renderPage();
});
document.getElementById('next-btn').addEventListener('click', () => {
    const total = Math.ceil(filtered.length / PAGE);
    currentPage = (currentPage + 1) % total;
    renderPage();
});

renderPage();
</script>
</body>
</html>