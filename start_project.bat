@echo off
title Dea Bakery - Server & ADB Reverse Launcher
echo ========================================================
echo        DEA BAKERY - AUTOMATIC SERVER LAUNCHER
echo ========================================================
echo.

echo [1/2] Menghubungkan Android Phone ke Backend via ADB Reverse...
if exist "C:\Android\platform-tools\adb.exe" (
    "C:\Android\platform-tools\adb.exe" reverse tcp:8000 tcp:8000 >nul 2>&1
    echo  [OK] Port 8000 berhasil di-forward ke HP Android!
) else (
    adb reverse tcp:8000 tcp:8000 >nul 2>&1
    echo  [OK] ADB reverse selesai!
)

echo.
echo [2/2] Menjalankan Server Laravel Backend di port 8000...
echo  - Akses Lokal: http://127.0.0.1:8000/api
echo  - Akses LAN: http://0.0.0.0:8000/api
echo.
echo Server sedang berjalan... Jangan tutup jendela ini saat menggunakan aplikasi!
echo ========================================================
echo.

cd /d "%~dp0backend_toko_roti"
php artisan serve --host=0.0.0.0 --port=8000
pause
