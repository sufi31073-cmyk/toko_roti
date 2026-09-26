@echo off
title Dea Bakery - Full Project Launcher
echo ========================================================
echo        DEA BAKERY - FULL APP & SERVER LAUNCHER
echo ========================================================
echo.

echo [1/3] Menghubungkan Android Phone via ADB Reverse...
if exist "C:\Android\platform-tools\adb.exe" (
    "C:\Android\platform-tools\adb.exe" reverse tcp:8000 tcp:8000 >nul 2>&1
) else (
    adb reverse tcp:8000 tcp:8000 >nul 2>&1
)
echo  [OK] Port 8000 berhasil di-forward ke Android!

echo.
echo [2/3] Menjalankan Server Laravel Backend di background...
start "Dea Bakery - Backend Server" cmd /k "cd /d %~dp0backend_toko_roti && php artisan serve --host=0.0.0.0 --port=8000"
echo  [OK] Server Backend aktif di http://127.0.0.1:8000

echo.
echo [3/3] Menjalankan Aplikasi Flutter di HP Android...
cd /d "%~dp0toko_roti"
flutter run
pause
