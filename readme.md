# OJ_NG

[![Build Status](https://travis-ci.org/CUGBOJ/newhope.svg?branch=master)](https://travis-ci.org/CUGBOJ/newhope)

##

本项目为 `中国地质大学（北京）(CUGB)`ACM 集训队成员基于`laravel`&`vue.js`面向学校开发的第四代`Online Judge`平台。

---

## 目录

-   [环境安装](#环境安装)
    -   [Mysql](#mysql)
    -   [PHP](#php)
    -   [NodeJS & NPM](#nodejs-npm)
    -   [Composer](#composer)
    -   [HTTP Server](#http-server)
-   [相关配置](#相关配置)
    -   [Clone 项目](#clone项目)
    -   [项目配置](#项目配置)
    -   [运行项目](#运行项目)
-   [开发约定 (TODO)](#开发约定)
    -   [数据库结构](#数据库结构)
    -   [表单验证规则](#表单验证规则)
-   [Test](#test)
-   [其他](#其他)
    -   [更换软件源](#换源)
    -   [HTTP Server 配置](#http-server配置)

---

## 环境安装

#### 该项目依赖与以下环境，请自行检查是否已经安装以及版本符合要求

-   Mysql Server
-   PHP （>=7.0)
-   NodeJS (>=8.0)
-   Composer
-   HTTP Server

### Mysql

**Linux User(Ubuntu for example):**

```shell
apt-get install mysql-server
```

**Windows User:**

访问[官方网站](https://dev.mysql.com/downloads/installer)， 自行选择合适版本下载并安装

### PHP

**Linux User(Ubuntu for example):**

```shell
apt-get install php7.0 php7.0-zip php7.0-dev php7.0-json php7.0-mbstring php7.0-mysql php7.0-curl php7.0-xml
cd /etc/php/7.0/fpm/
vi php.ini
```

取消下面几行的注释

```ini
;extension=php_curl.dll
;extension=php_mbstring.dll
;extension=php_mysqli.dll
;extension=php_openssl.dll
;extension=php_pdo_mysql.dll
```

**Windows User:**

访问 http://windows.php.net/download 选择 `Non-Thread-Safe` & `.zip` 版本，解压至相关目录后，将该目录配置进入环境变量中，复制`php.ini-development`并更名为`php.ini`

打开`php.ini`，寻找到`extension_dir=`，取消改行注释并将值修改为`{php安装路径}\ext`文件夹

取消下面几行的注释

```ini
;extension=php_curl.dll
;extension=php_mbstring.dll
;extension=php_mysqli.dll
;extension=php_openssl.dll
;extension=php_pdo_mysql.dll
```

**macOS User:**

使用 [homebrew](https://brew.sh/) 安装 PHP

```shell
brew update
brew search php
brew install php71
```

### Composer

[Composer](https://getcomposer.org/download/) 是 PHP 的一个依赖管理工具。它允许你申明项目所依赖的代码库，它会在你的项目中为你安装他们。
请自行访问其官网，获取下载及安装方式

### NodeJS & NPM

请自行访问官网，获取下载及安装方式

### HTTP Server

可以使用`nginx`，`apache`等 HTTP 服务器

开发环境推荐使用 PHP 内置服务器

---

## 相关配置

### Clone 项目

通过以下命令来克隆项目(**windows 用户 需要自行安装 git**)

```shell
git clone https://github.com/CUGBOJ/newhope.git
```

请 fork 该项目来进行 pull request

### 首次运行配置

首次运行时，需要进行一些环境配置。

1.  在数据库中创建一个 Database

2.  复制项目中的`.env.example` 为一个新文件 `.env`。打开`.env`，根据先前的数据库配置情况填写`DB_DATABASE`, `DB_USERNAME` , `DB_PASSWORD`等字段。

3.  安装所有依赖库

```shell
composer install
npm i
```

4.  运行以下命令来生成 laravel 需要的 `key`

```shell
php artisan key:generate
```

如果你是 linux 用户，请保证`{YourProject}/storage/` 和 `{YourProject}/bootstrap/cache`两个目录具备写入权限。

### 运行项目

```shell
composer update
composer dump-autoload
php artisan migrate:refresh --seed
npm install
npm run dev #npm run watch 可以监控js代码变化，实时编译
```

每次从上游获取代码后，需再次运行上述命令以重新安装相关依赖、迁移数据库、部署数据库模式的最新更改。

最后在项目路径下使用以下命令启动 PHP 内置服务器

```shell
php artisan serve
```

打开 http://127.0.0.1:8000 即可看到部署成功的网站

可以增加`--port=<the_port_you_want>`参数来指定端口，默认为 8000

---

## Test

Run PHP tests

```
./vendor/phpunit/phpunit/phpunit
```

## 其他

### 换源

更换 Composer 软件源到国内源，可以有效提升速度与稳定性。

```shell
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```

使用 [cnpm](https://npm.taobao.org/) 来代替 npm

```shell
npm install -g cnpm --registry=https://registry.npm.taobao.org
```

### HTTP Server 配置

#### Nginx

1.  修改 nginx 配置文件

```shell
cd /etc/nginx/sites-available/
vi default
```

2.  在列表中增加 index.php

```nginx
index index.php index.html index.htm index.nginx-debian.html;
```

3.  将 Web 服务器的根目录指向 public 目录。该目录下的 index.php 文件将作为所有进入应用程序的 HTTP 请求的前端控制器。

```nginx
root {YourProject}/public;
```

4.  其他配置

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
