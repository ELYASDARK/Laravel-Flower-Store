@echo off
REM Setup Storage Symbolic Link for Flower Store
REM This script creates the symbolic link required for image uploads

echo ========================================
echo Flower Store - Storage Setup
echo ========================================
echo.

REM Check if running as administrator
net session >nul 2>&1
if %errorLevel% == 0 (
    echo Running with Administrator privileges...
    echo.
) else (
    echo WARNING: Not running as Administrator!
    echo You may need to run this script as Administrator on Windows.
    echo.
)

REM Create symbolic link
echo Creating storage symbolic link...
php artisan storage:link

if %errorLevel% == 0 (
    echo.
    echo ========================================
    echo SUCCESS!
    echo ========================================
    echo Storage symbolic link created successfully.
    echo Images can now be uploaded and displayed.
    echo.
) else (
    echo.
    echo ========================================
    echo ERROR!
    echo ========================================
    echo Failed to create symbolic link.
    echo.
    echo Troubleshooting:
    echo 1. Make sure PHP is installed and in your PATH
    echo 2. Run this script as Administrator
    echo 3. Check that Laravel is properly installed
    echo.
)

pause


