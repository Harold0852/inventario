@echo off
:: Define la fecha actual
for /f "tokens=2-4 delims=/ " %%a in ('date /t') do set fecha=%%a_%%b_%%c

:: Ruta del archivo donde se guarda el backup
set backup_file=C:\xampp\htdocs\inventario\database\backups\backup_inventario_wsl_%fecha%.sql

:: Mensaje para depuración
echo Creando backup de base de datos, no cierre esta ventana: %backup_file%

:: Guarda los errores y hace el backup de MySQL
"C:\xampp\mysql\bin\mysqldump.exe" -u root inventario_wsl > "%backup_file%" 2> error_log.txt

:: Verifica si el backup se creó correctamente
if not exist "%backup_file%" (
    echo ERROR: No se pudo generar el backup. Revisa error_log.txt
    type error_log.txt
    exit /b 1
)

:: Sube el archivo a Google Drive con la aplicación Rclone
rclone copy "%backup_file%" drive:/Backups/

:: Borra los backups antiguos mayor a de 7 días
forfiles /P C:\xampp\htdocs\inventario\database\backups /M *.sql /D -7 /C "cmd /c del @file"

:: Borra backups antiguos en Google Drive mayor a de 7 días
rclone delete --min-age 7d drive:/Backups/

echo Backup completado correctamente.
exit