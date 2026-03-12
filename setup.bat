@echo off
REM RAMS Region III - Setup Script for Windows
REM Run this script to set up the entire system

echo.
echo ========================================
echo   RAMS Region III - Setup Script
echo ========================================
echo.

REM Step 1: Install Dependencies
echo [1/5] Installing dependencies...
call composer install
call npm install
echo [OK] Dependencies installed
echo.

REM Step 2: Environment Setup
echo [2/5] Setting up environment...
if not exist .env (
    copy .env.example .env
    echo [OK] .env file created
) else (
    echo [OK] .env file already exists
)

call php artisan key:generate
echo [OK] Application key generated
echo.

REM Step 3: Database Setup
echo [3/5] Setting up database...
call php artisan migrate
echo [OK] Migrations completed

call php artisan db:seed
echo [OK] Database seeded with agencies and test users
echo.

REM Step 4: Build Assets
echo [4/5] Building assets...
call npm run build
echo [OK] Assets built
echo.

REM Step 5: Summary
echo ========================================
echo   Setup Complete!
echo ========================================
echo.
echo Next Steps:
echo 1. Start the development server:
echo    php artisan serve
echo.
echo 2. Visit the application:
echo    http://localhost:8000
echo.
echo 3. Test Credentials:
echo    Email: dict@example.com
echo    Password: password
echo    Agency: DICT Region III
echo.
echo Documentation:
echo    - SETUP.md - Complete setup guide
echo    - IMPLEMENTATION.md - Technical details
echo    - QUICK_REFERENCE.md - Quick lookup
echo    - CHECKLIST.md - Feature checklist
echo.
echo Happy monitoring!
echo.
pause
