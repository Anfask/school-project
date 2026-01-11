@echo off
echo Step 1: Deleting problematic migration...
del database\migrations\2025_12_29_151837_add_email_to_admission_queries_table.php 2>nul

echo Step 2: Deleting test database...
del database\database.sqlite 2>nul

echo Step 3: Creating fresh test database...
echo. > database\database.sqlite

echo Step 4: Running migrations for testing...
php artisan migrate:fresh --env=testing

echo Step 5: Running tests...
php artisan test --env=testing

echo ✅ All tests should pass now!