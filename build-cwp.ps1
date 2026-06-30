$deployDir = "cwp_deploy"
if (Test-Path $deployDir) { Remove-Item -Recurse -Force $deployDir }
New-Item -ItemType Directory -Path $deployDir | Out-Null
New-Item -ItemType Directory -Path "$deployDir/minecart-core" | Out-Null

# Copy everything except node_modules, .git, and the deploy dir itself
$exclude = @("node_modules", ".git", "cwp_deploy", "cwp-deploy.zip", ".env.example", ".env")
Get-ChildItem -Exclude $exclude | Copy-Item -Destination "$deployDir/minecart-core" -Recurse

# Also copy .env and .env.example manually because hidden files sometimes behave weirdly in Copy-Item
Copy-Item ".env" -Destination "$deployDir/minecart-core/"
Copy-Item ".env.example" -Destination "$deployDir/minecart-core/"

# Move public folder contents to the root of cwp_deploy
Move-Item -Path "$deployDir/minecart-core/public/*" -Destination $deployDir
Move-Item -Path "$deployDir/minecart-core/public/.*" -Destination $deployDir -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force "$deployDir/minecart-core/public"

# Modify index.php
$indexContent = Get-Content "$deployDir/index.php" -Raw
$indexContent = $indexContent -replace "require __DIR__.'/../vendor/autoload.php';", "require __DIR__.'/minecart-core/vendor/autoload.php';"
$indexContent = $indexContent -replace "\`$app = require_once __DIR__.'/../bootstrap/app.php';", "\`$app = require_once __DIR__.'/minecart-core/bootstrap/app.php';"
Set-Content -Path "$deployDir/index.php" -Value $indexContent -Encoding UTF8

# Modify .env for production
$envContent = Get-Content "$deployDir/minecart-core/.env" -Raw
$envContent = $envContent -replace "APP_ENV=local", "APP_ENV=production"
$envContent = $envContent -replace "APP_DEBUG=true", "APP_DEBUG=false"
$envContent = $envContent -replace "APP_URL=http://localhost", "APP_URL=https://pangeranvalerensco.full.diskon.cloud"
$envContent = $envContent -replace "DB_CONNECTION=pgsql", "DB_CONNECTION=mysql"
Set-Content -Path "$deployDir/minecart-core/.env" -Value $envContent -Encoding UTF8

# Zip it
Compress-Archive -Path "$deployDir\*" -DestinationPath "cwp-deploy.zip" -Force
Remove-Item -Recurse -Force $deployDir
Write-Output "Berhasil! File cwp-deploy.zip siap di-upload ke CWP."
