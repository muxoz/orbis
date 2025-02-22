Package | Version
--- | ---
Laravel | v11
MoonShine  | v3
moonshine-roles-permissions | v3

## Instalación
Así es como puedes ejecutar el proyecto localmente:

1. Clona el repositorio
    ```sh
    git clone https://github.com/estivenm0/compranax.git
    ```

2. Navega al directorio raíz del proyecto
    ```sh
    cd compranax
    ```

3. Copia el archivo `.env.example` a `.env`
    ```sh
    cp .env.example .env
    ```


4. Instala las dependencias
    ```sh
    composer install
    ```

5. Genera la clave de la aplicación
    ```sh
    php artisan key:generate
    ```

6. Ejecuta las migraciones
    ```sh
    php artisan migrate
    ```

7. Genera permisos y role Super Admin
    ```sh
    php artisan moonshine:generate-permissions
    ```

8. Crea un Usuario
    ```sh
    php artisan moonshine-rbac:user
    ```