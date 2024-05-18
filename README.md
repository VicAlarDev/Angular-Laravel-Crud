# Crud Laravel + Angular

Este proyecto es un CRUD simple de una lista de tareas, desarrollado con Laravel y Angular.

## Requisitos

- PHP >= 7.4
- Composer
- Node.js
- Angular CLI
- MySQL o PostgreSQL

## Configuración del Proyecto

### Backend - Laravel

1.  **Clonar el Repositorio**  
    Clona este monorepo en tu máquina local usando:

    ```bash
    git clone https://github.com/VicAlarDev/Angular-Laravel-Crud.git
    ```

2.  **Instalar Dependencias de Laravel**
    Navega a la carpeta `api` y ejecuta:

    ```bash
    composer install
    ```

3.  **Configurar el Archivo .env**

    Copia el archivo `.env.example` a `.env` y modifica las variables de entorno según tu entorno local:

        ```bash
        cp .env.example .env
        ```

    Asegúrate de configurar las opciones de la base de datos:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=tu_host
    DB_PORT=tu_puerto
    DB_DATABASE=laravel
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
    ```

4.  **Ejecutar Migraciones**  
    Para configurar tu base de datos, ejecuta:

        ```bash
        php artisan migrate
        ```

5.  **Iniciar el Servidor de Laravel**

    Para iniciar el servidor de Laravel, ejecuta:

    ```bash
    php artisan serve
    ```

    El servidor se iniciará en `http://localhost:8000`.

### Frontend - Angular

1. **Instalar Dependencias de Angular**

   Navega a la carpeta `frontend` y ejecuta:

   ```bash
   npm install
   ```

2. **Iniciar el Servidor de Angular**

   Para iniciar el servidor de Angular, ejecuta:

   ```bash
   ng serve
   ```

   El servidor se iniciará en `http://localhost:4200`.

## Uso

Una vez que hayas configurado el proyecto, puedes acceder a la aplicación en `http://localhost:4200`.
