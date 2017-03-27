
## 这是一个很好用的轮子，基于Laravel.
### 由于官方木有中文支持，特意翻译过来希望都用得上,不用天天造轮子
汉化： ❤️ by [timwang](http://dbtoo.com) 


<hr>


# 安装方式：

## 首先安装laravel5.3版本
```bash
    composer create-project laravel/laravel=5.3.* --prefer-dist
```

## 开始安装轮子
```bash
    composer require timtoday/voyager-cn
```

修改 .env 中的数据库选项:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

如果需要可以修改 `APP_URL`:

```
APP_URL=localhost:8000
```

修改`config/app.php` 文件中的 `providers` 数组:

```php
'providers' => [
    // Laravel Framework Service Providers...
    //...
    
    // 增加这一行
    TCG\Voyager\VoyagerServiceProvider::class,
    // ...
    
    // Application Service Providers
    // ...
],
```
把本地化语言改成中文:
```
    'locale' => 'zh',
```

 
 
包含测试数据安装

```bash
php artisan voyager:install --with-dummy
```

好啦，启动Laravel服务器：
```bash
    php artisan serve
```
访问后台测试地址: [http://localhost:8000/admin](http://localhost:8000/admin).

默认管理员：
>**email:** `admin@admin.com`   
>**password:** `password`

如果是无测试数据安装，可以命令方式创建管理员
```bash
php artisan voyager:admin your@email.com
```

或者：

```bash
php artisan voyager:admin your@email.com --create
```
