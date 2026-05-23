# Docker Deployment Guide for Portfolio Application

## Project Overview

This is a Laravel 13 portfolio application with:
- PHP 8.3 FPM
- MySQL 8.0 database
- Redis for caching and queues
- Vite with Tailwind CSS
- Nginx web server

## Quick Start

### Prerequisites

- Docker Desktop (or Docker + Docker Compose)
- Git

### 1. Build and Start the Application

```bash
# Clone the repository (if not already done)
git clone <your-repo-url>
cd portfolio

# Copy environment file
cp .env.docker .env

# Build and start containers
docker-compose up -d

# Run migrations (if enabled in .env)
docker-compose exec app php artisan migrate

# Seed the database (if needed)
docker-compose exec app php artisan db:seed
```

### 2. Access the Application

- **Application**: http://localhost/8000
- **MySQL**: localhost:3306 (user: laravel, password: password)
- **Redis**: localhost:6379

### 3. Common Commands

```bash
# View logs
docker-compose logs -f app

# Execute artisan commands
docker-compose exec app php artisan tinker

# Create admin user
docker-compose exec app php artisan tinker
>>> App\Models\Admin::create(['email' => 'admin@example.com', 'password' => bcrypt('password')])

# Run tests
docker-compose exec app php artisan test

# Composer commands
docker-compose exec app composer require package-name

# NPM commands
docker-compose exec app npm install
docker-compose exec app npm run build
```

## Production Deployment

### Environment Setup

For production, update `.env` with:

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
DB_PASSWORD=<strong-password>
MAIL_HOST=<your-mail-provider>
MAIL_USERNAME=<your-email>
MAIL_PASSWORD=<your-password>
```

### SSL/TLS Configuration

1. **Using Let's Encrypt with Certbot**:

```bash
# Install Certbot
sudo apt-get install certbot python3-certbot-nginx

# Obtain certificate
sudo certbot certonly --standalone -d your-domain.com

# Update nginx configuration with certificate paths
# Edit: docker/nginx/default-proxy.conf
```

2. **Using Docker volumes**:

```bash
# Mount certificates in docker-compose.yml
volumes:
  - /etc/letsencrypt:/etc/letsencrypt:ro
```

### Reverse Proxy Setup

The `nginx-proxy` service handles HTTPS termination. Update the certificate paths in:
- `docker/nginx/default-proxy.conf`

### Database Backup & Recovery

```bash
# Backup database
docker-compose exec db mysqldump -u laravel -ppassword portfolio_db > backup.sql

# Restore database
docker-compose exec db mysql -u laravel -ppassword portfolio_db < backup.sql

# Or using volumes
docker-compose volumes inspect portfolio_dbdata
```

### Scaling

```bash
# Scale queue workers
docker-compose up -d --scale laravel-queue-worker=3

# Monitor performance
docker stats
```

## Architecture

### Services

1. **app** - PHP-FPM with Laravel application
   - Runs PHP application code
   - Handles queue jobs and scheduling
   - Manages caching

2. **db** - MySQL 8.0 database
   - Persistent data storage
   - Health checks enabled

3. **redis** - Redis cache/queue service
   - Session storage
   - Queue jobs
   - Cache layer

4. **nginx-proxy** - Nginx reverse proxy
   - HTTPS/SSL termination
   - Load balancing (optional)
   - Security headers

## Monitoring & Logging

```bash
# View application logs
docker-compose logs -f app

# View database logs
docker-compose logs -f db

# View nginx logs
docker-compose logs -f nginx-proxy

# Stream all logs
docker-compose logs -f

# View supervisor logs (inside container)
docker-compose exec app tail -f /var/log/supervisor/*.log
```

## Maintenance

### Cleanup

```bash
# Remove stopped containers
docker system prune

# Remove unused volumes
docker volume prune

# Remove all containers and volumes (WARNING: data loss!)
docker-compose down -v
```

### Updates

```bash
# Pull latest images
docker-compose pull

# Rebuild application
docker-compose build --no-cache

# Restart services
docker-compose restart
```

## Security Best Practices

1. ✅ Use strong database passwords in production
2. ✅ Enable SSL/TLS certificates
3. ✅ Regularly update Docker images
4. ✅ Use environment variables for sensitive data
5. ✅ Implement rate limiting on sensitive endpoints
6. ✅ Enable CORS properly for your domain
7. ✅ Use `.dockerignore` to exclude sensitive files
8. ✅ Keep Laravel packages updated: `composer update`

## Troubleshooting

### Port Already in Use

```bash
# Find and kill process using port 80
sudo lsof -i :80
sudo kill -9 <PID>
```

### Database Connection Errors

```bash
# Check database health
docker-compose exec db mysql -u laravel -ppassword -e "SELECT 1;"

# Restart database
docker-compose restart db
```

### Permission Errors

```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Memory Issues

```bash
# Increase Docker memory limit
# Edit Docker Desktop settings or docker daemon.json

# Monitor memory usage
docker stats
```

## Additional Resources

- [Laravel Docker Documentation](https://laravel.com/docs/deployment)
- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Reference](https://docs.docker.com/compose/compose-file/)

## Support

For issues or questions:
1. Check Docker logs: `docker-compose logs`
2. Review this guide
3. Check Laravel documentation
4. Submit issue on GitHub repository
