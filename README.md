# CodeIgniter 4 Application Starter

## How to start?

**First advice**: Verify if has `cache` folder inside of `writable` folder of application to avoid `PHP Fatal error:  Uncaught CodeIgniter\Cache\Exceptions\CacheException: Cache unable to write to "/address/CodeIgniter/c4-hxh/writable/cache/". in /address/CodeIgniter/c4-hxh/vendor/codeigniter4/framework/system/Cache/Handlers/FileHandler.php:66`, see below to solve this:
```
# Verify your operating system and where you store the application (I'm using Ubuntu distro)
user@user:~$ cd ~/address/c4-hxh/writable
user@user:~/address/c4-hxh/writable$ mkdir cache
```

**Second advice**: To get commands of CodeIgniter framework use this command:
```
php spark list
```

1 - Run the following command to install dependencies of repository (It's necessary `composer` installed).
```
composer install 
```

2 - Create `.env` file using the command:
```
php spark env 
```

Case the `.env` has not been created, just create `.env` file manually in the project. After, it is necessary copy the details from this [link](https://github.com/codeigniter4/CodeIgniter4/blob/develop/env) in your `.env`.

3 - Run the following command to generate `encryption.key` value of `.env`.
```
php spark key:generate
```

4 - Change the following informations in `.env`:
```
# MySQL
database.default.hostname = 127.0.0.1
database.default.database = c4-hxh
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

# PostgreSQL
database.default.hostname = localhost
database.default.database = c4-hxh
database.default.username = postgres
database.default.password = 
database.default.DBDriver = Postgre
database.default.DBPrefix =
database.default.port = 5432
```

5 - Add the command to create the migrations:
```
php spark migrate
```

6 - When executing the migrations, is necessary use the commands to create some populated tables to some selection fields at forms.
```
php spark db:seed

# Following you need specify the seeders (You must specify each one in turn, so is necessary execute php spark db:seed for choose the seeder file)
- TipoHunterSeeder
- TipoNenSeeder
- TipoSanguineoSeeder
```

8 - Run the application.
```
php spark serve
```