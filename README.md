## Prerequisites

Before you begin, make sure you have the following installed:

- [PHP](https://www.php.net/downloads) (v8.2 or later)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/downloads/) or another database supported by Laravel
- [Docker] (https://docs.docker.com/docker-for-mac/install/)

You can verify the versions of these tools by running the following commands:
php -v
composer -v
mysql --version

## Installation
Clone the repository to your local machine:
https://github.com/jomsq/crm-au-laravel.git
cd crm-au-laravel

this will clone the project with 2 folders
- code: this is the location of the laravel project
- docker - this is the location of the docker configurations

## Docker Features
- `nginx` - Already configured with SSL/TLS
- `php` - All the drivers for `SQL Server ODBC Drivers`, `Active Directory via LDAP`. Configurable PHP version
- `mysql` - Data is stored on local disk NOT INSIDE container. Persists across rebuilding container.
- `composer` - Easily run all your favorite composer commands.
- `artisan` - Easily run all your favorite artisan commands.
- `npm` - Easily run all your favorite npm commands.
- `phpunit` - Easily run your unit tests.
- `redis` - Easily use redis for your session cache.
- `horizon` - Easily use horizon to manage your workers and job queues.
- `cron` - Easily use cron to schedule periodic commands.

## Docker Configuration
Copy `.env_example` to `.env` and set the following variables:

#### Application Settings
- `COMPOSE_PROJECT_NAME=crm_app` Used in the docker-compose.yml file to namespace the services.
- `APP_DOMAIN=crm_app.local` - Used in the nginx service to automatically create a self-signed certificate for this domain.
- `PATH_TO_CODE=../code` - Location of the code that is used to configure map volumes into the containers

#### Docker Container Versions
The following are used to set the container versions for the services. Here is an example configuration:
- `PHP_VERSION=8.2` Laravel 11 requires 8.2 PHP Version
- `MYSQL_VERSION=5.7.32`
- `NODE_VERSION=13.7`
- `REDIS_VERSION=latest`
- `NGINX_VERSION=stable`

#### Docker Services Exposed Ports
The following are used to configure the exposed ports for the services. Here is an example, but update to de-conflict ports:
- `HTTP_ON_HOST=8001`
- `HTTPS_ON_HOST=44301`
- `MYSQL_ON_HOST=33061`
- `REDIS_ON_HOST=6379`

#### Database Settings
The following are used by docker when building the database service:
- `MYSQL_DATABASE=abc_db`
- `MYSQL_USER=laravel`
- `MYSQL_PASSWORD=secret`
- `MYSQL_ROOT_PASSWORD=secret`

### Hosts File
For local development, update your Operating System's host file using the code sudo nano /etc/hosts

- `127.0.0.1     crm_app.local`

### Run the Docker
docker-compose up -d --build nginx
Open the browser and go to https://crm_app.local:44301/

## Usage

When the container network is up, the following services and their ports are available to the host machine:

- **nginx** - `:HTTPS_ON_HOST`, `:HTTP_ON_HOST`
- **mysql** - `:MYSQL_ON_HOST`
- **redis** - `:REDIS_ON_HOST`

Additional containers are included that are not brought up with the webserver stack, and are instead used as "command services". These allow you to run commands that interact with your application's code, without requiring their software to be installed and maintained on the host machine. These are:

- `docker-compose run --rm composer <COMMAND>` runs a composer command
- `docker-compose run --rm artisan <COMMAND>` runs an artisan command
- `docker-compose run --rm npm <COMMAND>` runs a npm command 
- `docker-compose run --rm cron` starts a crontab that runs the `php artisan schedule` command
- `docker-compose run -d horizon` starts a new horizon container (you can start multiple horizon containers)
- `docker-compose stop horizon` stops all the horizon containers

You would use them just like you would with their native counterparts, including your command after any of those lines above (e.g. `docker-compose run --rm artisan db:seed`).

You can create an interactive shell by doing one of the following:

- `docker-compose run -it --entrypoint /bin/bash <SERVICE>`
-  `docker compose exec -it <SERVICE> /bin/sh`

## Laravel Configuration

In the code folder, Copy `.env_example` to `.env` and set the following variables:

APP_URL=https://crm_app.local:44301/

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=abc_db
DB_USERNAME=laravel
DB_PASSWORD=secret

SESSION_DRIVER=redis
CACHE_DRIVER=redis
REDIS_HOST=redis

After that completes, run the following to install and compile the dependencies for the application. in the docker folder, run:
- `docker-compose run --rm composer install`
- `docker-compose run --rm npm install`
- `docker-compose run --rm npm run dev`
- `docker-compose run --rm artisan key:generate`
- `docker-compose run --rm artisan migrate`
