@echo off
REM ─── IBSEA Queue — Windows Task Scheduler Setup ───────────────────────────
REM Run this ONCE as Administrator to register the queue worker as an automatic task.
REM After this, it runs silently every minute — no window, no manual steps needed.

set PROJECT=C:\xampp\htdocs\ibsea-laravel
set PHP=C:\xampp\php\php.exe

REM Create Task: runs every 1 minute, silently, in background
schtasks /create /tn "IBSEA_Email_Queue" ^
  /tr "\"%PHP%\" \"%PROJECT%\artisan\" queue:work --queue=emails --once --timeout=1800 --tries=1" ^
  /sc MINUTE /mo 1 ^
  /ru SYSTEM ^
  /f

echo.
echo ============================================
echo  Task Scheduler task created successfully!
echo  Name: IBSEA_Email_Queue
echo  Runs every 1 minute automatically.
echo ============================================
echo.
echo To remove: schtasks /delete /tn "IBSEA_Email_Queue" /f
pause
