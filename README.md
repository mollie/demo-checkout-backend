# Mollie Checkout backend

Mollie Checkout for iOS and Android require a backend to securely handle payments. The backend provides the API endpoints needed to run the Mollie Checkout demo apps, and it supports Mollie's webhook for handling payments.

This backend is written in PHP 8.0 and uses [Laravel](https://laravel.com/). It uses [Composer](https://getcomposer.org/) to manage the PHP dependencies.

> :information_source: **Info**: You need PHP 8.0, MySQL, and Composer 2.1 to use this backend.

## Set up the backend

There are three main steps to set up the backend:

 1. [Clone the repository](#step-1-clone-the-repository)
 2. [Configure the environment](#step-2-configure-the-environment)
 3. [Test API endpoints](#step-3-test-api-endpoints)

### Step 1: Clone the repository

Follow the steps below to clone and set up the backend.
1. Pick a location on your machine.
2. [Clone](https://docs.github.com/en/get-started/getting-started-with-git/about-remote-repositories) the Mollie Checkout backend repository:

```bash
# Clone the project
git clone git@github.com:mollie/demo-checkout-backend.git
cd mollie_checkout_backend
```

3. Copy the required environment variables to create your environment configuration file. The application uses these for environment-specific configuration.

```bash
# Create your environment configuration file
cp .env.example .env
```

4. Set your Mollie API key.

``` bash
# Set the `MOLLIE_KEY` environment variable (underneath)
nano .env
```

> :white_check_mark: **Tip**: Go to your [Mollie dashboard](https://mollie.com/dashboard) to get your API keys. If you use your test key during development, remember to update the configuration with your live key when you publish your backend.

### Step 2: Configure the environment

After cloning the repository, you can either set up Mollie Checkout [using Docker](#set-up-docker) or by [running a local machine](#run-local-machine). 

#### Set up Docker

[Docker](https://www.docker.com/get-started) is a tool that uses containers to make it easier to create, deploy, and run applications.

To set up Docker, follow the steps below.
1. [Install Docker](https://www.docker.com/get-started) on your machine.
2. Use the commands below to complete your Docker setup.

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

You have now configured and launched a Docker instance that contains PHP, Laravel, Composer, and MySQL.

#### Run local machine

Instead of using Docker, you can set up Mollie Checkout on your local machine.

1. Set up Laravel, PHP, and MySQL on your local machine.
2. Create a database and configure your `.env` file
3. Run the project on your development server.


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

### Step 3: Test API endpoints
Mollie Checkout uses API endpoints that are documented in [Swagger](https://swagger.io/).

To test the endpoints in [Swagger UI](https://swagger.io/tools/swagger-ui/), use [http://localhost:8000/api/doc](http://localhost:8000/api/doc).

## Webhook

Mollie uses webhooks to handle realtime payment status updates. You must make your Mollie Checkout backend public to receive and handle the webhooks.

To handle this, you can set up a port that forwards webhooks to your machine. However, this is complex to set up. We recommend using a tunneling tool such as [ngrok](https://ngrok.com/) instead.

It's not possible to receive webhook callbacks when using localhost. In this case, the `webhookUrl` is left empty when creating a payment.

## Resources

Read [our docs](https://docs.mollie.com) for more information about Mollie.
