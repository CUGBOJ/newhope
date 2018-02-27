OJ_NG
====
[![Build Status](https://travis-ci.org/CUGBOJ/newhope.svg?branch=master)](https://travis-ci.org/CUGBOJ/newhope)

##
本项目为 `中国地质大学（北京）(CUGB)`ACM集训队成员基于`laravel`&`vue.js`面向学校开发的第四代`Online Judge`平台。

****
## 目录
* [环境安装](#环境安装)
    * [Mysql](#mysql)
    * [PHP](#php)
    * [NodeJS & NPM](#nodejs-npm)
    * [Composer](#composer)
    * [Http server](#http_server)
* [相关配置](#相关配置)
    * [换源](#换源)
    * [Clone项目](#clone项目)
    * [项目配置](#项目配置)
    * [Http_server配置](#http_server配置)
    * [安装第三方包与依赖](#安装第三方包与依赖)
* [开发约定](#开发约定)
    * [数据库结构](#数据库结构)
    * [表单验证规则](#表单验证规则)
* [Test](#test)
* [其他](#其他)


----

## 环境安装

####该项目依赖与以下环境，请自行检查是否已经安装以及版本符合要求

>Mysql Server<br>
PHP （>=7.0）<br>
nodejs&npm (>???)<br>
composer<br>
Http server


### Mysql

**Linux User(Ubuntu for example):**

>apt-get install mysql-server

**Windows User:**

>登录 https://dev.mysql.com/downloads/installer ， 自行选择合适版本下载并安装



### PHP

**Linux User(Ubuntu for example):**

```shell
apt-get install php7.0 php7.0-zip php7.0-dev php7.0-json php7.0-mbstring php7.0-mysql php7.0-curl php7.0-xml
cd /etc/php/7.0/fpm/
vi php.ini
```

>取消下面几行的注释
```shell
;extension=php_curl.dll
;extension=php_mbstring.dll
;extension=php_mysqli.dll
;extension=php_openssl.dll
;extension=php_pdo_mysql.dll
```


**Windows User:**

>访问 http://windows.php.net/download 选择 `Non-Thread-Safe` & `.zip` 版本>
解压至相关目录后，将该目录配置进入环境变量中
复制php.ini-development并更名为php.ini

>打开php.ini，寻找到`extension_dir=`,取消改行注释并将值修改为`php安装路径\ext`文件夹

>取消下面几行的注释
```shell
;extension=php_curl.dll
;extension=php_mbstring.dll
;extension=php_mysqli.dll
;extension=php_openssl.dll
;extension=php_pdo_mysql.dll
```

**macOS User:**

使用 [homebrew](https://brew.sh/) 安装 PHP

```
brew update
brew search php
brew install php71
```

### Composer

[Composer](https://getcomposer.org/download/) 是 PHP 的一个依赖管理工具。它允许你申明项目所依赖的代码库，它会在你的项目中为你安装他们。
请自行访问其官网，获取下载及安装方式


### NodeJS & NPM

请自行访问官网，获取下载及安装方式

### HTTP_server
可以使用`nginx`，`apache`等Http服务器
开发人员推荐使用PHP内置服务器

----
## 相关配置

### 换源
该步骤不是必须，可以跳过。

更换Composer与国内的源，可以有效提升速度与稳定性。
```shell
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```

使用 [cnpm](https://npm.taobao.org/) 来代替npm
```shell
npm install -g cnpm --registry=https://registry.npm.taobao.org
```

### Clone项目

通过以下命令来克隆项目(**windows用户 需要自行安装git**)
```shell
git clone https://github.com/CUGBOJ/newhope.git
```
请fork该项目来进行 pull request


### 项目配置

>复制项目中的 **.env.example** 为 **.env**
打开.env 根据本地环境填写相关配置`DB_DATABASE`, `DB_USERNAME` , `DB_PASSWORD` 
运行以下命令来生成key
```shell
php artisan key:generate
```

如果你是linux用户，请为`YourProject/storage/` and `YourProject/bootstrap/cache`两个目录授予相应权限可以写入
### Http_server配置

你可以在项目路径下使用以下命令来启动PHP内置服务器
```shell
php artisan serve
```
可以增加 **--port=80**参数来指定端口，默认为8000， 即 http://127.0.0.1:8000

#### 如果你使用 nginx，请进行以下配置

>1. 修改nginx配置文件
```shell
cd /etc/nginx/sites-available/
vi default
```
>2. 在列表中增加index.php
```nginx
index index.php index.html index.htm index.nginx-debian.html;
```
>3. 将 Web 服务器的根目录指向 public 目录。该目录下的 index.php 文件将作为所有进入应用程序的 HTTP 请求的前端控制器。**Your_Project_Path is a path**
```nginx
root Your_Project_Path/public;
```

>4. 其他配置
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

### 安装第三方包与依赖

>运行以下命令安装相关依赖
```shell
composer update
npm install
```
_可以使用cnpm来代替npm_

<br>

>使用 npm run dev 来运行相关js文件，详细信息请参考package.json
```shell
npm run dev
```
<br>


每次从上游获取代码后，请进行以下命令迁移数据库以部署数据库模式的最新更改。
```shell
composer dump-autoload
php artisan migrate:refresh --seed
```
<br>

如果 `composer.json` and `package.json`被修改请运行下面的命令
```shell
composer update
npm install
```

----

## Test

Run PHP tests

```
./vendor/phpunit/phpunit/phpunit
```

##其他
