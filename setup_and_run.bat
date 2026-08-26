@echo off
echo ====================================
echo   SIKOPIM - Setup Database
echo ====================================

echo.
echo [1/4] Starting MySQL...
start /B "" "C:\xampp\mysql\bin\mysqld.exe" --defaults-file="C:\xampp\mysql\bin\my.ini" --standalone

echo Waiting for MySQL to start (10s)...
timeout /t 10 /nobreak >nul

echo.
echo [2/4] Checking MySQL connection...
"C:\xampp\mysql\bin\mysqladmin.exe" -u root ping
if errorlevel 1 (
    echo ERROR: MySQL failed to start! Retrying in 5s...
    timeout /t 5 /nobreak >nul
    "C:\xampp\mysql\bin\mysqladmin.exe" -u root ping
    if errorlevel 1 (
        echo FATAL: MySQL could not start!
        pause
        exit /b 1
    )
)

echo.
echo [3/4] Ensuring APP_KEY and Database...
php artisan key:generate --force
"C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS sikopim CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
echo Database 'sikopim' ready.

echo.
echo [4/4] Running migrations and seeding...
php artisan migrate:fresh --seed --force

if errorlevel 1 (
    echo.
    echo ERROR: Migration failed! Check output above.
    "C:\xampp\mysql\bin\mysqladmin.exe" -u root shutdown
    pause
    exit /b 1
)

echo.
echo ====================================
echo   Setup Complete! 
echo   Login: admin / admin123
echo   URL  : http://localhost:8000
echo ====================================

echo.
echo Starting Laravel development server...
echo Press Ctrl+C to stop the server.
php artisan serve

echo.
echo Shutting down MySQL...
"C:\xampp\mysql\bin\mysqladmin.exe" -u root shutdown
