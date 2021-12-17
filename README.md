# Mollie Checkout backend

The demo apps (Mollie Checkout for iOS and Android) need a simple API in order to work. This project offers the necessary API endpoints required by the apps and supporting the webhook from Mollie in order to handle payments. The project is written in PHP 8.0 and uses [Laravel](https://laravel.com/). The PHP dependencies are managed by [Composer](https://getcomposer.org/). 

For more information about the inner workings of Mollie [docs.mollie.com](https://docs.mollie.com).

## Requirements

- PHP 8.0
- MySQL
- Composer 2.1

## Getting started

### Step 1: Clone

Pick a location on your machine to clone the project into.

```bash
# Clone the project
git clone git@git.webuildapps.com:mol/mollie_checkout_backend.git
cd mollie_checkout_backend
```

Copy the mandatory environment variables which will be used by the application for environment specific configuration. Set you Mollie api key which can be obtained from the Mollie dashboard at mollie.com.

```bash
# Create your environment configuration file
cp .env.example .env

# Set the `MOLLIE_KEY` environment variable (at the bottom)
nano .env
```

### Step 2: Configure

To make things easy Mollie Checkout can be setup through [Docker](https://www.docker.com/get-started). If you are already familiar with Laravel and have PHP and MySQL running on your local machine you can continue with Step 2b.

#### Step 2a: Docker

Docker is a tool designed to make it easier to create, deploy, and run applications by using containers. If you haven't installed Docker go to https://www.docker.com/get-started and install docker on your machine. After docker is installed follow these steps from the project folder.

```bash
# Build and start the docker containers
docker-compose up -d

# Install composer packages
docker-compose exec php composer install --no-interaction

# Generate application key
docker-compose exec php php artisan key:generate

# Run application migrations
docker-compose exec php php artisan migrate
```

#### Step 2b: Local machine

If you already have PHP and MySQL setup on your local machine you can go ahead by creating a database, configure your `.env` file and run the project on your development server.

```bash
# Edit the `DATABASE_*` environment variables
nano .env

# Generate application key
php artisan key:generate

# Run application migrations
php artisan migrate

# Run development server
php artisan serve
```

#### Step 3: Test

All of the API endpoints used by Mollie Checkout are documented in [Swagger](https://swagger.io/) and can be tested with [Swagger UI](https://swagger.io/tools/swagger-ui/). The Swagger UI is accessable through http://localhost:8000/api/doc.

## Webhook

Mollie uses webhooks to handle realtime payment status updates. In order to receive and handle those webhooks you have toe make your Mollie Checkout backend publicly accessible. This means setting up a tool like [ngrok](https://ngrok.com/) or go the hard way by setting up port forwarding to your machine.

When using localhost you won't receive webhook callbacks. In this case `webhookUrl` is not set when creating a payment.
