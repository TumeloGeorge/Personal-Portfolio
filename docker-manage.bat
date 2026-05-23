@echo off
REM Portfolio Docker Management Script for Windows
REM Simplifies common Docker operations

setlocal enabledelayedexpansion

set SCRIPT_DIR=%~dp0
set COMPOSE_FILE=%SCRIPT_DIR%docker-compose.yml
set COMPOSE_FILE_PROD=%SCRIPT_DIR%docker-compose.prod.yml
set ENV_FILE=%SCRIPT_DIR%.env

if "%1"=="" (
    call :show_help
    exit /b 0
)

goto %1

:show_help
echo.
echo Portfolio Docker Management Script
echo.
echo USAGE:
echo     docker-manage.bat [COMMAND]
echo.
echo COMMANDS:
echo     start           Start all containers
echo     stop            Stop all containers
echo     restart         Restart all containers
echo     build           Build containers
echo     logs            Show application logs
echo     bash            Access application bash shell
echo     tinker          Access Laravel Tinker REPL
echo     migrate         Run database migrations
echo     seed            Run database seeders
echo     test            Run PHP tests
echo     backup          Backup database
echo     clean           Remove stopped containers
echo     status          Show container status
echo     ps              List running containers
echo     shell-db        Access MySQL shell
echo     prod-up         Start production environment
echo     prod-down       Stop production environment
echo     help            Show this help message
echo.
echo EXAMPLES:
echo     docker-manage.bat start
echo     docker-manage.bat logs
echo     docker-manage.bat migrate
exit /b 0

:start
echo Starting containers...
docker-compose -f "%COMPOSE_FILE%" up -d
docker-compose -f "%COMPOSE_FILE%" ps
exit /b 0

:stop
echo Stopping containers...
docker-compose -f "%COMPOSE_FILE%" down
exit /b 0

:restart
echo Restarting containers...
docker-compose -f "%COMPOSE_FILE%" restart
docker-compose -f "%COMPOSE_FILE%" ps
exit /b 0

:build
echo Building containers...
docker-compose -f "%COMPOSE_FILE%" build --no-cache
exit /b 0

:logs
echo Showing application logs (Ctrl+C to exit)...
docker-compose -f "%COMPOSE_FILE%" logs -f app
exit /b 0

:bash
echo Entering application bash shell (type 'exit' to leave)...
docker-compose -f "%COMPOSE_FILE%" exec app sh
exit /b 0

:tinker
echo Entering Laravel Tinker (type 'exit' to leave)...
docker-compose -f "%COMPOSE_FILE%" exec app php artisan tinker
exit /b 0

:migrate
echo Running database migrations...
docker-compose -f "%COMPOSE_FILE%" exec app php artisan migrate
exit /b 0

:seed
echo Running database seeders...
docker-compose -f "%COMPOSE_FILE%" exec app php artisan db:seed
exit /b 0

:test
echo Running tests...
docker-compose -f "%COMPOSE_FILE%" exec app php artisan test
exit /b 0

:backup
for /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c%%a%%b)
for /f "tokens=1-2 delims=/:" %%a in ('time /t') do (set mytime=%%a%%b)
set BACKUP_FILE=backup_%mydate%_%mytime%.sql
echo Backing up database to %BACKUP_FILE%...
docker-compose -f "%COMPOSE_FILE%" exec db mysqldump -u laravel -ppassword portfolio_db > "%BACKUP_FILE%"
echo Database backed up to: %BACKUP_FILE%
exit /b 0

:clean
echo Cleaning up Docker resources...
docker-compose -f "%COMPOSE_FILE%" down -v
docker image prune -f
echo Cleanup complete
exit /b 0

:status
docker-compose -f "%COMPOSE_FILE%" ps
exit /b 0

:ps
docker ps
exit /b 0

:shell-db
echo Entering MySQL shell (type 'exit' to leave)...
docker-compose -f "%COMPOSE_FILE%" exec db mysql -u laravel -ppassword portfolio_db
exit /b 0

:prod-up
echo Starting production environment...
if not exist "%ENV_FILE%" (
    echo Error: .env file not found
    exit /b 1
)
docker-compose -f "%COMPOSE_FILE_PROD%" up -d
docker-compose -f "%COMPOSE_FILE_PROD%" ps
exit /b 0

:prod-down
echo Stopping production environment...
docker-compose -f "%COMPOSE_FILE_PROD%" down
exit /b 0

:help
call :show_help
exit /b 0

echo Unknown command: %1
call :show_help
exit /b 1
