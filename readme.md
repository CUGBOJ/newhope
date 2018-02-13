# Getting Started

## Setup

### Manual Build

Get composer and install all dependencies.

```shell
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

Write your `.env` file based on your local evironment.

```
mv .env.example .env
```

Modify the `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` according to your machine's setting.

Set up the HTTP server in http://127.0.0.1:8000

```
php artisan serve
```
