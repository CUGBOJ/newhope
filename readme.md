# Getting Started

## Setup

### The required environment


#### 1.HTTP server(nginx,apache...)
Install nginx/apache or you can use PHP's server
#### 2.PHP (>=7.0)
linux user:(ubuntu)
```shell
apt-get install php7.0 php7.0-zip php7.0-dev php7.0-json php7.0-mbstring php7.0-mysql php7.0-curl php7.0-xml
cd /etc/php/7.0/fpm/
vi php.ini
```
cancel the comment of
```shell
;extension=extension=php_curl.dll
;extension=extension=php_mbstring.dll
;extension=extension=php_mysqli.dll
;extension=extension=php_openssl.dll
```

windows user:

request http://windows.php.net/download and choose Non-Thread-Safe & .zip vision

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
please notice **PHP-Installation-Path is a path**

cancel the comment of
```shell
;extension=extension=php_curl.dll
;extension=extension=php_mbstring.dll
;extension=extension=php_mysqli.dll
;extension=extension=php_openssl.dll
```

#### 3.composer
    
the official website of composer
https://getcomposer.org/download/
please learn more from it.
#### 4.nodejs&npm
learn more from internet, and please notice your operating system

#### 5.mysql
learn more from internet, and please notice your operating system

### Change the source

Change the source of composer to improve the speed.
```shell
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```
use cnpm to replace npm
```shell
npm install -g cnpm --registry=https://registry.npm.taobao.org
```


### Clone the project

fork the existing project and clone the project.
**if you have any questions of git please learn from Internet**


### Other Config


Write your `.env` file based on your local evironment.

```
mv .env.example .env
```

Modify the `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` according to your machine's setting.

If you are linux user please notice you must have 
permission to write 
```dir
YourProject/storage/
```
```dir
YourProject/bootstrap/cache
```

#### if you don't want use nginx, a good suggestion following

Set up the HTTP server in http://127.0.0.1:8000

```
php artisan serve
```

#### if you use nginx, you need to change the congig

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
```vim
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

#### install the vendor of php&nodejs
Please use the commad in your project
```shell
composer update
npm install
```
Sure you can use cnpm to replace npm.

you can use the commod to run scripts of dev 
learn more from package.json
```shell
npm run dev
``` 
#### every times after update code by git
migrate the database
```shell
composer dump-autoload
php artisan migrate:refresh --seed
```
if the composer.json or package.json are modified
```shell
composer update
npm install
```



