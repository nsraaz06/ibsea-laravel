@echo off
title IBSEA Email Queue Worker
color 0A
echo ============================================
echo   IBSEA Email Campaign Queue Worker
echo   Sending emails in background...
echo   DO NOT CLOSE this window.
echo ============================================
echo.

:loop
C:\xampp\php\php.exe C:\xampp\htdocs\ibsea-laravel\artisan queue:work --queue=emails --once --timeout=3600 --tries=1
timeout /t 5 /nobreak >nul
goto loop
