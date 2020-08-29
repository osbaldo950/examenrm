## Instalación de la plantilla

### 1.- Clonar el repostorio en local

```bash
git clone https://github.com/osbaldo950/admintemplatelaravel7.git
```

### 2.- Instalar paquetes de la aplicación

```bash
composer install
```

### 3.- Crear y configurar archivo .env de nuestra aplicación, realizando la conexión a la base de datos

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=BD
DB_USERNAME=USER
DB_PASSWORD=PASS
```

### 4.- Crear la llave de la aplicación

```bash
php artisan key:generate 
```

### 5.- Borrar cache de la aplicación

```bash
php artisan config:cache
```

### 6.- Ejecutar las migraciones

```bash
php artisan migrate
```

### 7.- Iniciar servidor laravel

```bash
php artisan serve
```

### 8.- Ir a url del servidor

```bash
http://127.0.0.1:8000/
```

### 9.- Iniciar sesion en la aplicación

```bash
user: admin@admin.com
pass: admin
```

