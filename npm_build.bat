@echo off
echo ==============================================
echo SIPANDA FRONTEND BUILD (TAILWIND CSS V4 + VITE)
echo ==============================================
echo.

echo [Step 1] Installing npm dependencies...
call npm install
if %ERRORLEVEL% neq 0 (
    echo Error: npm install failed.
    pause
    exit /b %ERRORLEVEL%
)
echo Dependencies installed successfully.
echo.

echo [Step 2] Building assets with Vite...
call npm run build
if %ERRORLEVEL% neq 0 (
    echo Error: npm run build failed.
    pause
    exit /b %ERRORLEVEL%
)
echo.
echo ==============================================
echo Build Completed Successfully!
echo ==============================================
pause
