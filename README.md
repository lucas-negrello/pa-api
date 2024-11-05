# Personal Assistent API

This is a Laravel-based API for Personal Assistance application, providing secure authentication and API functionality powered by Sanctum with Redis for caching and sessions.

## Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Environment Variables](#environment-variables)
- [Running the Project](#running-the-project)
- [Database Migrations](#database-migrations)
- [API Authentication](#api-authentication)
- [Usage](#usage)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
- [Docker Configuration](#docker-configuration)
- [Contributing](#contributing)
- [License](#license)

---

## Docker Configuration

The Docker setup is organized by environment and managed within the `.docker` folder. Each environment has a detailed README with configuration details:

- [Development Configuration](.docker/development/README.md)

This section covers Docker Compose, Dockerfile, Nginx, PHP, and other settings for each environment.

---

## Requirements
------------

-   **Docker** and **Docker Compose** for containerized environment
-   **PHP** (8.2), **PostgreSQL**, and **Redis** set up in Docker containers
-   **Composer** for PHP dependencies

Installation
------------

1.  **Clone the Repository**:

    ```bash
    git clone https://github.com/lucas-negrello/pa-api.git
    cd pa-api
    ```

2.  **Install PHP Dependencies**:

    ```bash
    composer install
    ```

3.  **Set Up Environment File**: Copy `.env.example` to `.env` and update configuration settings as needed.

    ```bash
    cp .env.example .env
    ```

4.  **Generate Application Key**:

    ```bash
    php artisan key:generate
    ```

Environment Variables
---------------------

Configure the following variables in the `.env` file:


```dotenv
# Application Configuration
APP_NAME=pa-api
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

# Database Configuration
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=pa-api
DB_USERNAME=root
DB_PASSWORD=password

# Redis Configuration
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=redis
REDIS_PORT=6379

# Sanctum Configuration
SANCTUM_STATEFUL_DOMAINS=localhost
SESSION_DOMAIN=localhost
```

Running the Project
-------------------

1.  **Start the Containers**:

    ```bash
    docker-compose up --build -d
    ```

2.  **Run Migrations**: After starting the containers, migrate the database:

    ```bash
    docker exec app php artisan migrate
    ```

3.  **Check the Application**:

    -   Access the API at: `http://localhost:{APP_PORT}` (default: 8084).
    -   The API is served through Nginx and powered by PHP-FPM.

Database Migrations
-------------------

To create or update the database schema, run migrations with:

```bash
docker-compose exec app php artisan migrate
```

To rollback the last migration, run:

```bash
docker-compose exec app php artisan rollback
```

API Authentication
------------------

This project uses **Laravel Sanctum** for token-based authentication.

1.  **Register**: `POST /api/register` - Create a new user.
2.  **Login**: `POST /api/login` - Log in and retrieve an access token.
3.  **Logout**: `POST /api/logout` - Invalidate the user's access token.

### Sample Request Headers for Protected Routes

For routes protected by `auth:sanctum`, include the JWT token in the `Authorization` header:

```http request
Authorization: Bearer {token}
```

Usage
-----

[//]: # (1.  **Access User Profile**: `GET /api/user`)

[//]: # (2.  **Add Telemetry Data**: `POST /api/telemetry` &#40;Protected route&#41;)

[//]: # (3.  **Retrieve Telemetry Data**: `GET /api/telemetry` &#40;Protected route&#41;)

[//]: # ()
[//]: # (Additional routes and their details are available in the `routes/api.php` file.)

Testing
-------

1.  **Run Tests**: Use PHPUnit to run tests within the Docker container:

    ```bash
    docker exec app php artisan test
    ```

2.  **API Testing**: Use tools like Postman or cURL to test API endpoints and ensure responses match expected output.

Troubleshooting
---------------

-   **Database Connection Issues**:

    -   Verify the `DB_HOST` and `DB_PORT` in the `.env` file and ensure they match the settings in `docker-compose.yml`.
    -   Restart the containers with `docker-compose down && docker-compose up -d` if connection issues persist.
-   **Redis Issues**:

    -   Ensure `CACHE_DRIVER` and `SESSION_DRIVER` are both set to `redis` in `.env`.
    -   Check Redis logs with `docker-compose logs redis` for any errors.

Contributing
------------

Contributions are welcome! Please fork the repository and create a pull request with your changes. Follow the project's coding guidelines and ensure all new features are covered by tests.

License
-------

This project is licensed under the MIT License. See the LICENSE file for more details.
