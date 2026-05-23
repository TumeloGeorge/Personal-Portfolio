# Quick Start Guide for Docker Deployment

## Step 1: Prepare Environment

```bash
# Copy the docker environment file to .env
cp .env.docker .env

# Edit .env with your configuration:
# - Set DB_PASSWORD to a strong password
# - Configure MAIL_* settings if needed
# - Update APP_URL if deploying to a domain
```

## Step 2: Build and Start

**Linux/macOS:**
```bash
# Make script executable
chmod +x docker-manage.sh

# Start containers
./docker-manage.sh start
```

**Windows:**
```bash
# Start containers
docker-manage.bat start
```

**Or use docker-compose directly:**
```bash
docker-compose up -d
docker-compose exec app php artisan migrate
```

## Step 3: Verify Installation

```bash
# Check if all containers are running
docker-compose ps

# View logs
docker-compose logs -f app

# Access the application
# Open: http://localhost
```

## Step 4: Create Admin Account

**Linux/macOS:**
```bash
./docker-manage.sh tinker
```

**Windows:**
```bash
docker-manage.bat tinker
```

**In Tinker console:**
```php
>>> App\Models\Admin::create([
    'email' => 'admin@example.com',
    'password' => bcrypt('your-secure-password'),
    'name' => 'Admin User'
])
```

## Database Access

**From host machine:**
- Host: `localhost`
- Port: `3306`
- Username: `laravel`
- Password: (as set in .env)
- Database: `portfolio_db`

**From container:**
```bash
docker-compose exec db mysql -u laravel -p portfolio_db
# Enter password when prompted
```

## Common Tasks

### View Logs
```bash
# Application logs
docker-compose logs -f app

# Database logs
docker-compose logs -f db

# All services
docker-compose logs -f
```

### Run Artisan Commands
```bash
docker-compose exec app php artisan [command]

# Examples:
docker-compose exec app php artisan migrate:fresh
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan tinker
```

### Rebuild Assets
```bash
docker-compose exec app npm run build
```

### Run Tests
```bash
docker-compose exec app php artisan test
```

## Production Deployment

### Using Production Compose File

```bash
# Copy and configure production env
cp .env.docker .env

# Edit .env for production:
# - Set APP_ENV=production
# - Set APP_DEBUG=false
# - Set APP_URL=https://your-domain.com
# - Use strong passwords for DB_PASSWORD and REDIS_PASSWORD
# - Configure mail settings

# Start production environment
docker-compose -f docker-compose.prod.yml up -d
```

### SSL/TLS Setup

1. **Install Certbot:**
```bash
sudo apt-get install certbot python3-certbot-nginx
```

2. **Get Certificate:**
```bash
sudo certbot certonly --standalone -d your-domain.com
```

3. **Update nginx config:**
Edit `docker/nginx/default-proxy.conf` and update:
```nginx
ssl_certificate /etc/letsencrypt/live/your-domain.com/fullchain.pem;
ssl_certificate_key /etc/letsencrypt/live/your-domain.com/privkey.pem;
```

4. **Restart nginx:**
```bash
docker-compose restart nginx-proxy
```

### Auto-renewal

```bash
# Setup auto-renewal cron job
sudo crontab -e

# Add line:
0 2 * * * /usr/bin/certbot renew --quiet && docker-compose -f /path/to/docker-compose.prod.yml restart nginx-proxy
```

## Troubleshooting

### Containers won't start
```bash
# Check logs
docker-compose logs

# Rebuild containers
docker-compose build --no-cache
docker-compose up -d
```

### Database connection error
```bash
# Wait for database to be ready
sleep 10

# Run migrations
docker-compose exec app php artisan migrate
```

### Port already in use
```bash
# Find process on port 80
sudo lsof -i :80

# Kill process
sudo kill -9 <PID>
```

### Permission issues
```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

## Cleanup

```bash
# Stop and remove containers (keep data)
docker-compose down

# Stop and remove everything including volumes (WARNING: data loss!)
docker-compose down -v

# Remove unused Docker resources
docker system prune
```

## File Structure

```
portfolio/
├── Dockerfile                 # Main application image
├── docker-compose.yml         # Development environment
├── docker-compose.prod.yml    # Production environment
├── .dockerignore              # Files to exclude from build
├── .env.docker               # Docker environment template
├── docker-manage.sh          # Linux/macOS management script
├── docker-manage.bat         # Windows management script
├── docker/
│   ├── nginx/
│   │   ├── nginx.conf        # Nginx configuration
│   │   ├── default.conf      # App server config
│   │   └── default-proxy.conf # SSL proxy config
│   ├── supervisor/
│   │   └── supervisord.conf  # Process management
│   └── entrypoint.sh         # Container startup script
└── DOCKER_DEPLOYMENT.md      # Full deployment guide
```

## Support

For detailed information, see [DOCKER_DEPLOYMENT.md](DOCKER_DEPLOYMENT.md)

For Laravel documentation: https://laravel.com
For Docker documentation: https://docs.docker.com
