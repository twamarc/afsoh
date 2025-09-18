$ErrorActionPreference = "Stop"
Write-Host "Starting Docker for afsoh..." -ForegroundColor Cyan

# Basic checks
if (-not (Get-Command docker -ErrorAction SilentlyContinue)) { Write-Host "Docker not found. Start Docker Desktop, then re-run." -ForegroundColor Red; exit 1 }
docker version > $null 2>&1; if ($LASTEXITCODE -ne 0) { Write-Host "Docker daemon not running. Start Docker Desktop, then re-run." -ForegroundColor Red; exit 1 }

# Compose v2 uses `docker compose` (not docker-compose)
if (-not (Test-Path ".\docker-compose.yml")) { Write-Host "docker-compose.yml not found in $PWD. Create it first, then re-run." -ForegroundColor Yellow; exit 1 }

# Ensure site folder exists
if (-not (Test-Path ".\www")) { New-Item -ItemType Directory -Path ".\www" -Force | Out-Null }

# Bring up stack
Write-Host "Running: docker compose up -d --build" -ForegroundColor Green
docker compose up -d --build
if ($LASTEXITCODE -ne 0) { Write-Host "docker compose failed. Check logs with: docker compose logs -f" -ForegroundColor Red; exit 1 }

Start-Sleep -Seconds 5
Start-Process "http://localhost:8080"
Write-Host "Done. Opened http://localhost:8080" -ForegroundColor Cyan
