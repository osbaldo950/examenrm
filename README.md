## Instalación Examen

### Tecnologías utilizadas en proyecto:
```bash
php
laravel 7.0
php requerido PHP >= 7.2.5
javascript
jquery 3.6
bootstrap 4
css 3
html 5
git clone https://github.com/osbaldo950/examenrm.git
```
### 1.- Clonar el repostorio en local

```bash
git clone https://github.com/osbaldo950/examenrm.git
```

### 2.- Entrar a la carpeta clonada y instalar paquetes de la aplicación

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

### 8.- Ir a url del servidor en nuestro navegador

```bash
http://127.0.0.1:8000/
```

### 9.- Iniciar sesion en la aplicación

```bash
user: admin@admin.com
pass: admin
```

