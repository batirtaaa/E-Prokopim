@echo off
echo ================================
echo  Starting XAMPP MySQL...
echo ================================
C:\xampp\mysql\bin\mysqld.exe --defaults-file="C:\xampp\mysql\bin\my.ini" --standalone &

echo Waiting for MySQL to start...
timeout /t 5 /nobreak

echo Creating database...
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS sikopim CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo.
echo Database 'sikopim' is ready!
echo ================================
echo  Now run: php artisan migrate --seed
echo ================================
pause
