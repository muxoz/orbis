| Package                     | Version | Description                  |
| --------------------------- | ------- | ---------------------------- |
| Laravel                     | v11     | Core PHP framework           |
| MoonShine                   | v3      | Admin panel                  |
| moonshine-roles-permissions | v3      | Roles and permissions system |
| internachi/modular          | v2      | Modular architecture         |

## 🚀 Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/muxoz/orbis.git
    cd orbis
    ```

2. Set up the environment:

    ```bash
    cp .env.example .env
    composer install
    ```

3. Run the installer:
    ```bash
    php artisan launch:install
    ```

4. Set test data
    ```sh
    php artisan db:seed
    ```
