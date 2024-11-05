# Development Environment - Docker Configuration

This document describes the Docker configuration for the **Development** environment of the Toigosa Telemetry API project.

## Table of Contents
- [Overview](#overview)
- [docker-compose.yml](#docker-composeyml)
- [Dockerfile](#dockerfile)
- [Nginx Configuration](#nginx-configuration)
- [PHP Configuration](#php-configuration)
- [.env Variables](#env-variables)

---

## Overview

The development environment is set up to replicate production conditions as closely as possible while allowing rapid testing and debugging. It includes:
- **PHP 8.2** (FPM) for running the Laravel application
- **Nginx** as the web server
- **PostgreSQL** as the primary database
- **Redis** for caching and session management

## docker-compose.yml

The `docker-compose.yml` defines the service stack and network for the development environment. Below is a summary of each service and its configuration:

### app (PHP-FPM)

- **Image**: `php:8.2-fpm`
- **Build Context**: Uses the `Dockerfile` in the `development` folder.
- **Environment**:
    - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` are set to connect to the `db` container.
- **Ports**: Exposes the app via `APP_PORT` (configured in `.env`).
- **Volume**:
    - Maps the local application directory to `/var/www/html` inside the container.
    - Mounts the custom `php.ini` for development-specific PHP settings.
- **Extra Hosts**: Adds `host.docker.internal` to allow local development access.

### db (PostgreSQL)

- **Image**: `postgres:latest`
- **Environment**:
    - Uses `DB_USERNAME`, `DB_PASSWORD`, and `DB_DATABASE` from `.env`.
- **Ports**: Exposes the database on `DB_PORT` (configured in `.env`).
- **Volume**: Maps `DBVOLUME` to persist PostgreSQL data on the local filesystem.

### redis

- **Image**: `redis:latest`
- **Ports**: Exposes the Redis instance on `REDIS_PORT` (configured in `.env`).

### nginx

- **Image**: `nginx:latest`
- **Ports**: Exposes Nginx on `APP_PORT` for access to the application.
- **Volume**:
    - Maps the project `APPVOLUME` to `/var/www/html`.
    - Mounts the `nginx.conf` configuration file for custom settings.

---

## Dockerfile

The `Dockerfile` in `.docker/development` builds the PHP-FPM image with all required extensions for PostgreSQL, Redis, and other dependencies.

### Steps

- **Base Image**: `php:8.2-fpm`
- **Extensions**:
    - Installs `pdo` and `pdo_pgsql` for PostgreSQL.
    - Installs and enables Redis via `pecl`.
- **Composer**:
    - Installs Composer from the official Composer image to manage Laravel dependencies.

## Nginx Configuration

The `nginx.conf` file configures Nginx as a reverse proxy to handle requests for the Laravel application:

```nginx
# nginx.conf

worker_processes 1;

events {
    worker_connections 1024;
}

http {
    include /etc/nginx/mime.types;
    default_type application/octet-stream;

    sendfile on;
    keepalive_timeout 65;

    server {
        listen 80;
        server_name localhost;

        root /var/www/html/public;  # Laravel's public directory
        index index.php index.html;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
            fastcgi_pass app:9000;  # Connects to PHP-FPM in app service
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include fastcgi_params;
        }
    }
}
```

PHP Configuration
-----------------

The `php.ini` file in the `.docker/development` folder customizes PHP settings for development:

```bash
[PHP]
post_max_size = 100M
upload_max_filesize = 100M
variables_order = EGPCS
pcov.directory = .
```

-   **post_max_size** and **upload_max_filesize**: Increased to allow larger uploads.
-   **variables_order**: Ensures environment variables are loaded in order.
-   **pcov.directory**: Used for code coverage in development.

.env Variables
--------------

The following variables in `.env` are used to configure the development environment:

```dotenv
# Docker-Compose Settings
COMPOSE_PROJECT_NAME=pa-api
APPVOLUME=/home/negrello/Projects/personal-assistent/pa-api
DBVOLUME=/home/negrello/Projects/personal-assistent/data
BIND_HOST=127.0.0.1:

# Application Ports
APP_PORT=8084
VITE_PORT=8080

# Database Settings
DB_HOST=db
DB_PORT=5442
DB_USERNAME=root
DB_PASSWORD=password
DB_DATABASE=pa_api

# Redis Settings
REDIS_PORT=7379
```
