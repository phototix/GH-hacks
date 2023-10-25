@echo off
:loop
ping -n 1 www.google.com > nul
if errorlevel 1 (
    shutdown /r /t 60
    exit
)
timeout /t 300 /nobreak
goto loop
