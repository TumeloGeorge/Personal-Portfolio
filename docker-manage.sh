#!/bin/bash

# Portfolio Docker Management Script
# Simplifies common Docker operations

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
COMPOSE_FILE="${SCRIPT_DIR}/docker-compose.yml"
COMPOSE_FILE_PROD="${SCRIPT_DIR}/docker-compose.prod.yml"
ENV_FILE="${SCRIPT_DIR}/.env"

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Functions
print_header() {
    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ $1${NC}"
}

# Usage help
show_help() {
    cat << EOF
${BLUE}Portfolio Docker Management Script${NC}

USAGE:
    ./docker-manage.sh [COMMAND]

COMMANDS:
    start           Start all containers
    stop            Stop all containers
    restart         Restart all containers
    build           Build containers
    logs            Show application logs
    bash            Access application bash shell
    tinker          Access Laravel Tinker REPL
    migrate         Run database migrations
    seed            Run database seeders
    test            Run PHP tests
    composer [cmd]  Run composer commands
    npm [cmd]       Run npm commands
    artisan [cmd]   Run artisan commands
    backup          Backup database
    restore [file]  Restore database from file
    clean           Remove stopped containers and volumes
    status          Show container status
    ps              List running containers
    shell-db        Access MySQL shell
    prod-up         Start production environment
    prod-down       Stop production environment
    help            Show this help message

EXAMPLES:
    ./docker-manage.sh start
    ./docker-manage.sh logs
    ./docker-manage.sh artisan migrate:fresh
    ./docker-manage.sh npm run build
    ./docker-manage.sh backup
    ./docker-manage.sh restore backup.sql
EOF
}

# Container commands
cmd_start() {
    print_header "Starting containers..."
    docker-compose -f "${COMPOSE_FILE}" up -d
    print_success "Containers started"
    cmd_status
}

cmd_stop() {
    print_header "Stopping containers..."
    docker-compose -f "${COMPOSE_FILE}" down
    print_success "Containers stopped"
}

cmd_restart() {
    print_header "Restarting containers..."
    docker-compose -f "${COMPOSE_FILE}" restart
    print_success "Containers restarted"
}

cmd_build() {
    print_header "Building containers..."
    docker-compose -f "${COMPOSE_FILE}" build --no-cache
    print_success "Build complete"
}

cmd_logs() {
    print_header "Showing application logs (Ctrl+C to exit)"
    docker-compose -f "${COMPOSE_FILE}" logs -f app
}

cmd_bash() {
    print_info "Entering application bash shell (type 'exit' to leave)"
    docker-compose -f "${COMPOSE_FILE}" exec app sh
}

cmd_tinker() {
    print_info "Entering Laravel Tinker (type 'exit' to leave)"
    docker-compose -f "${COMPOSE_FILE}" exec app php artisan tinker
}

cmd_migrate() {
    print_header "Running database migrations..."
    docker-compose -f "${COMPOSE_FILE}" exec app php artisan migrate
    print_success "Migrations complete"
}

cmd_seed() {
    print_header "Running database seeders..."
    docker-compose -f "${COMPOSE_FILE}" exec app php artisan db:seed
    print_success "Seeding complete"
}

cmd_test() {
    print_header "Running tests..."
    docker-compose -f "${COMPOSE_FILE}" exec app php artisan test
}

cmd_composer() {
    docker-compose -f "${COMPOSE_FILE}" exec app composer "$@"
}

cmd_npm() {
    docker-compose -f "${COMPOSE_FILE}" exec app npm "$@"
}

cmd_artisan() {
    docker-compose -f "${COMPOSE_FILE}" exec app php artisan "$@"
}

cmd_backup() {
    print_header "Backing up database..."
    BACKUP_FILE="backup_$(date +%Y%m%d_%H%M%S).sql"
    docker-compose -f "${COMPOSE_FILE}" exec db mysqldump -u laravel -ppassword portfolio_db > "${BACKUP_FILE}"
    print_success "Database backed up to: ${BACKUP_FILE}"
}

cmd_restore() {
    if [ -z "$1" ]; then
        print_error "Please specify backup file"
        echo "Usage: ./docker-manage.sh restore <backup-file>"
        exit 1
    fi
    
    if [ ! -f "$1" ]; then
        print_error "File not found: $1"
        exit 1
    fi
    
    print_header "Restoring database from: $1"
    docker-compose -f "${COMPOSE_FILE}" exec -T db mysql -u laravel -ppassword portfolio_db < "$1"
    print_success "Database restored"
}

cmd_clean() {
    print_header "Cleaning up Docker resources..."
    print_info "Removing stopped containers..."
    docker-compose -f "${COMPOSE_FILE}" down -v
    print_info "Pruning unused images..."
    docker image prune -f
    print_success "Cleanup complete"
}

cmd_status() {
    print_header "Container Status"
    docker-compose -f "${COMPOSE_FILE}" ps
}

cmd_ps() {
    docker ps
}

cmd_shell_db() {
    print_info "Entering MySQL shell (type 'exit' to leave)"
    docker-compose -f "${COMPOSE_FILE}" exec db mysql -u laravel -ppassword portfolio_db
}

cmd_prod_up() {
    print_header "Starting production environment..."
    if [ ! -f "${ENV_FILE}" ]; then
        print_error ".env file not found. Please create it from .env.example"
        exit 1
    fi
    docker-compose -f "${COMPOSE_FILE_PROD}" --env-file "${ENV_FILE}" up -d
    print_success "Production environment started"
    cmd_status
}

cmd_prod_down() {
    print_header "Stopping production environment..."
    docker-compose -f "${COMPOSE_FILE_PROD}" down
    print_success "Production environment stopped"
}

# Main
if [ $# -eq 0 ]; then
    show_help
    exit 0
fi

case "$1" in
    start)          cmd_start ;;
    stop)           cmd_stop ;;
    restart)        cmd_restart ;;
    build)          cmd_build ;;
    logs)           cmd_logs ;;
    bash)           cmd_bash ;;
    tinker)         cmd_tinker ;;
    migrate)        cmd_migrate ;;
    seed)           cmd_seed ;;
    test)           cmd_test ;;
    composer)       shift; cmd_composer "$@" ;;
    npm)            shift; cmd_npm "$@" ;;
    artisan)        shift; cmd_artisan "$@" ;;
    backup)         cmd_backup ;;
    restore)        shift; cmd_restore "$@" ;;
    clean)          cmd_clean ;;
    status)         cmd_status ;;
    ps)             cmd_ps ;;
    shell-db)       cmd_shell_db ;;
    prod-up)        cmd_prod_up ;;
    prod-down)      cmd_prod_down ;;
    help)           show_help ;;
    *)              print_error "Unknown command: $1"; show_help; exit 1 ;;
esac
