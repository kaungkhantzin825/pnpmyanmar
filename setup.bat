@echo off
echo ========================================
echo Video Blog Platform - Quick Setup
echo ========================================
echo.

echo [1/7] Installing Composer dependencies...
call composer install
if errorlevel 1 goto error

echo.
echo [2/7] Installing NPM dependencies...
call npm install
if errorlevel 1 goto error

echo.
echo [3/7] Copying environment file...
if not exist .env (
    copy .env.example .env
    echo .env file created
) else (
    echo .env file already exists
)

echo.
echo [4/7] Generating application key...
call php artisan key:generate
if errorlevel 1 goto error

echo.
echo [5/7] Running database migrations...
call php artisan migrate
if errorlevel 1 goto error

echo.
echo [6/7] Creating storage link...
call php artisan storage:link
if errorlevel 1 goto error

echo.
echo [7/7] Seeding database with sample data...
call php artisan db:seed --class=BlogSeeder
if errorlevel 1 goto error

echo.
echo ========================================
echo Setup completed successfully!
echo ========================================
echo.
echo Default Admin Credentials:
echo Email: admin@example.com
echo Password: password
echo.
echo To start the development server, run:
echo php artisan serve
echo.
echo Then visit: http://localhost:8000/blog
echo Admin panel: http://localhost:8000/admin/dashboard
echo.
pause
goto end

:error
echo.
echo ========================================
echo Setup failed! Please check the error above.
echo ========================================
echo.
pause

:end
