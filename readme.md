# Getting Started

## Setup

### Environment Required

#### HTTP server(Or use PHP built-in server, recommanded for development)

#### PHP (>=7.0)

**Linux User(Ubuntu for example):**

```shell
apt-get install php7.0 php7.0-zip php7.0-dev php7.0-json php7.0-mbstring php7.0-mysql php7.0-curl php7.0-xml
cd /etc/php/7.0/fpm/
vi php.ini
# Cancel the comment of
`
;extension=extension=php_curl.dll
;extension=extension=php_mbstring.dll
;extension=extension=php_mysqli.dll
;extension=extension=php_openssl.dll
`
```

**Windows User:**

Visit http://windows.php.net/download and choose Non-Thread-Safe & .zip version

```powershell
cp php.ini-development  php.ini
```

open php.ini to find

```shell
;extension_dir=""
```

remove the comment, and the value changed to

```shell
PHP-Installation-Path\ext
```

please notice `PHP-Installation-Path` is a path

cancel the comment of

```shell
;extension=extension=php_curl.dll
;extension=extension=php_mbstring.dll
;extension=extension=php_mysqli.dll
;extension=extension=php_openssl.dll
```

**macOS User:**

Use [homebrew](https://brew.sh/) to install PHP.

```
brew update
brew search php
brew install php71
```

#### composer

the official website of composer
https://getcomposer.org/download/
please learn more from it.

#### NodeJS & NPM

learn more from internet, and please notice your operating system

### Mysql

### Change Sources to Speed Up

Change the source of composer to improve the speed.

```shell
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```

Use [cnpm](https://npm.taobao.org/) to replace npm

```shell
npm install -g cnpm --registry=https://registry.npm.taobao.org
```

### Clone the project

Clone the project by running command

```shell
git clone https://github.com/CUGBOJ/newhope.git
```

Please fork the project for pull request.

### Other Config

Write your `.env` file based on your local evironment.

```shell
cp .env.example .env
```

Modify the `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` according to your machine's setting.

If you are a Linux user please notice you must have the permission to write `YourProject/storage/` and `YourProject/bootstrap/cache`.

Set up the HTTP server in http://127.0.0.1:8000

```
php artisan serve
```

#### if you use nginx, you need to change the config

```shell
cd /etc/nginx/sites-available/
vi default
```

Add index.php to the list

```shell
index index.php index.html index.htm index.nginx-debian.html;
```

change the root value

```shell
root Your_Project_Path/public;
```

**Your_Project_Path is a path**

other changes following,

```nginx
location / {
                  # First attempt to serve request as file, then
                  # as directory, then fall back to displaying a 404.
                  #try_files $uri $uri/ =404;
                  try_files $uri $uri/ /index.php?$query_string;
          }

 location ~ \.php$ {
                  include snippets/fastcgi-php.conf;
          #       # With php7.0-cgi alone:
          #       fastcgi_pass 127.0.0.1:9000;
          #       # With php7.0-fpm:
                  fastcgi_pass unix:/run/php/php7.0-fpm.sock;
          }
```

#### install the vendor of PHP & NodeJS

Please run these commands in your project to install dependencies.

```shell
composer update
npm install
```

_Surely you can use `cnpm` to replace `npm`._

you can use the command to run scripts for development
learn more from package.json

```shell
npm run dev
```

**every times after update code from upstream** please migrate the database to deploy the latest change of database schema.

```shell
composer dump-autoload
php artisan migrate:refresh --seed
```

And update dependencies if the `composer.json` and `package.json` are modified.

```shell
composer update
npm install
```
