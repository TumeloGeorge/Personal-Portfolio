# Tumelo George Portfolio & CMS

A full-stack personal portfolio website with a built-in Content Management System (CMS), built with Laravel 11, PostgreSQL, and a custom dark-themed frontend. Every piece of content — from the hero section to certifications and project thumbnails — is fully editable through the admin panel without touching a single line of code.

---

## Features

### Public Portfolio
- Dark, electric-blue themed responsive design
- Animated hero section with availability status badge
- Dynamic accent color (changeable from CMS — updates the entire site instantly)
- Skills grouped by category with primary/secondary chip styling
- Work experience timeline
- Certifications with badge logos and downloadable certificate files
- Projects grid with category filter tabs and carousel pagination
- Contact form with database-backed inbox
- Social links (LinkedIn, Behance, Dribbble, GitHub)
- CV/Resume download

### Admin CMS (`/admin`)
- Secure, password-protected admin panel (separate auth guard)
- **Settings** — site name, full name, role title, bio, accent color picker, avatar photo, CV upload, social links, availability toggle
- **Hero** — headline, subheadline, bio, CTA button labels, stats (projects, years, clients) — with live preview
- **Skills** — manage categories (name, icon, sort order) and individual skills (primary/secondary level)
- **Work Experience** — add/edit/delete timeline entries with year ranges
- **Certifications** — upload PDF or image certificates, badge logos, credential verification links
- **Projects** — thumbnail uploads, category tags, featured flag, project and case study URLs
- **Messages** — view contact form submissions with read/unread status, reply via email, delete

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 11 (PHP 8.4) |
| Database | PostgreSQL (MySQL for local dev) |
| Frontend | Blade templates, vanilla CSS, vanilla JS |
| Icons | Tabler Icons |
| Fonts | Inter (Google Fonts) |
| File Storage | Laravel Storage (local disk / S3-compatible) |
| Auth | Laravel custom guard (separate admin guard) |

---

## Project Structure

portfolio/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # All CMS controllers
│   │   │   ├── PortfolioController       # Public portfolio
│   │   │   └── ContactController         # Contact form handler
│   │   └── Middleware/
│   │       └── AdminAuthenticate          # Protects /admin routes
│   │
│   └── Models/
│       ├── Admin                          # CMS user (separate from User)
│       ├── Setting                        # Site-wide settings (single row)
│       ├── Hero                           # Hero section content (single row)
│       ├── SkillCategory                  # Skill groupings
│       ├── Skill                          # Individual skills
│       ├── Experience                     # Work history entries
│       ├── Certification                  # Certifications + file paths
│       ├── Project                        # Portfolio projects
│       └── ContactMessage                 # Inbox messages
│
├── database/
│   ├── migrations/                        # 9 custom migration files
│   └── seeders/
│       ├── AdminSeeder                    # Creates initial admin account
│       └── DefaultContentSeeder           # Seeds placeholder content
│
├── resources/
│   └── views/
│       ├── admin/                          # CMS views (layout, auth, all sections)
│       └── portfolio/
│           └── index.blade.php             # Full public portfolio (single page)
│
└── routes/
    └── web.php                             # Public + admin routes


---

## Local Setup

### Prerequisites
- PHP 8.4+
- Composer
- Node.js 18+ & npm
- PostgreSQL or MySQL

### Installation

**1. Clone the repository**
```bash
git clone https://github.com/yourusername/portfolio.git
cd portfolio
```

**2. Install dependencies**
```bash
composer install
npm install && npm run build
```

**3. Set up environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure `.env`**
```env
APP_URL=http://localhost:8000

# PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=portfolio_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

# Or MySQL for local dev
DB_CONNECTION=mysql
DB_PORT=3306

FILESYSTEM_DISK=public
SESSION_DRIVER=file
```

**5. Run migrations and seed**
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

**6. Start the server**
```bash
php artisan serve
```

Visit `http://localhost:8000` for the portfolio and `http://localhost:8000/admin/login` for the CMS.


---

## Database Schema

| Table | Purpose |
|-------|---------|
| `admins` | CMS admin accounts |
| `settings` | Single-row site configuration |
| `hero` | Single-row hero section content |
| `skill_categories` | Skill groupings (UI/UX, Visual, etc.) |
| `skills` | Individual skills linked to categories |
| `experiences` | Work history timeline entries |
| `certifications` | Certifications with file/badge paths |
| `projects` | Portfolio projects with thumbnails |
| `contact_messages` | Contact form inbox |

---

## Admin Panel Routes

| Route | Description |
|-------|-------------|
| `/admin/login` | Admin login page |
| `/admin/dashboard` | Overview stats and recent messages |
| `/admin/settings` | Site-wide settings and branding |
| `/admin/hero` | Hero section editor with live preview |
| `/admin/skills` | Skill categories and skills manager |
| `/admin/experiences` | Work experience timeline |
| `/admin/certifications` | Certifications and file uploads |
| `/admin/projects` | Portfolio projects manager |
| `/admin/messages` | Contact form inbox |

---

## File Uploads

Uploaded files are stored in `storage/app/public/` under these subdirectories:

| Folder | Contents |
|--------|---------|
| `avatars/` | Profile photo |
| `cv/` | CV / Resume PDF |
| `badges/` | Certification badge logos |
| `certificates/` | Certificate PDFs or images |
| `projects/` | Project thumbnail images |

Files are served via the `public` disk. Run `php artisan storage:link` to create the required symlink between `public/storage` and `storage/app/public`.

> **Windows note:** Run PowerShell as Administrator when running `php artisan storage:link`, or enable Developer Mode in Windows Settings.

---

## Deployment

### Environment variables for production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
FILESYSTEM_DISK=public
SESSION_DRIVER=database  # or redis
```

### Optimize for production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Storage in production
For persistent file storage across deployments, configure an S3-compatible bucket (AWS S3, Cloudflare R2, or DigitalOcean Spaces) and update `config/filesystems.php` accordingly.

---

## Docker 

Docker + docker-compose support for Render deployment, including:
- PHP 8.4 + Nginx container
- PostgreSQL container
- Persistent storage volumes
- Automated migration on startup

---

## License

This project is open source and available under the [MIT License](LICENSE).

---

## Author

**Tumelo George**  
Software Engineer & IT infrastructure Support Technician 
[LinkedIn](https://linkedin.com/in/tumelo-george-411a1a24b) 
