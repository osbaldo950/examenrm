## Instalación de la plantilla

### 1.- Clonar el repostorio en local

```bash
git clone https://github.com/osbaldo950/admintemplatelaravel7.git
```

### 2.- Instalar paquetes de la aplicación

```bash
composer install
```

### 3.- Configurar archivo .env de nuestra aplicación, realizando la conexión a la base de datos

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=BD
DB_USERNAME=USER
DB_PASSWORD=PASS
```

### 4.- Ejecutar las migraciones

```bash
php artisan migrate
```

### 5.- Iniciar servidor laravel##

```bash
php artisan serve
```

### 6.- Ir a url del servidor

```bash
http://127.0.0.1:8000/
```

### 7.- Iniciar sesion en APP

```bash
user: admin@admin.com
pass: admin
```

