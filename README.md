## Instalación de la plantilla

- ** 1.- Clonar el repostorio en local**
git clone https://github.com/osbaldo950/admintemplatelaravel7.git

- ** 2.- Instalar paquetes de la aplicación**
composer install

- ** 3.- Configurar archivo .env de nuestra aplicación, realizando la conexión a la base de datos **
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=BD
DB_USERNAME=USER
DB_PASSWORD=PASS

- ** 4.- Ejecutar las migraciones **
php artisan migrate

- ** 5.- Iniciar servidor laravel  **
php artisan serve

- ** 5.- Ir a url del servidor  **
http://127.0.0.1:8000/

- ** 5.- Iniciar sesion en APP  **
user: admin@admin.com
pass: admin


