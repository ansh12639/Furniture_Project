@echo off
echo ============================================
echo   Elegant Furniture Project - Docker Start
echo ============================================
echo.

REM Check Docker is running
docker info >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Docker is not running! Please start Docker Desktop first.
    pause
    exit /b 1
)

echo [1/3] Stopping any existing containers...
docker-compose down >nul 2>&1

echo [2/3] Building and starting services...
docker-compose up --build -d

if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Failed to start containers. Check Docker is working.
    pause
    exit /b 1
)

echo [3/3] Waiting for MySQL to be ready...
timeout /t 15 /nobreak >nul

echo.
echo ============================================
echo  SUCCESS! Website is running at:
echo  http://localhost:8080
echo.
echo  Admin Panel:
echo  http://localhost:8080/admin_panal/admin_login.php
echo.
echo  Admin Credentials:
echo    Username: admin
echo    Password: admin123
echo.
echo  Test User Credentials:
echo    Username: ansh1    Password: password123
echo    Username: shai     Password: shai123
echo    Username: halut    Password: halut123
echo ============================================
echo.
echo Press Ctrl+C or close this window to stop.
echo To stop the server run: docker-compose down
pause
