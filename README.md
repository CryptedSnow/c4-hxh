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

3 - Link to copy `.env` details [here](https://github.com/codeigniter4/CodeIgniter4/blob/develop/env).

4 - Run the following command to generate `encryption.key` value of `.env`.
```
php spark key:generate
```

5 - Change the following informations in `.env` (I'm using Linux distro like my operating system).
```
# MySQL
database.default.hostname = 127.0.0.1
database.default.database = ci4-mysql
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

# PostgreSQL
database.default.hostname = localhost
database.default.database = ci4-postgres
database.default.username = postgres
database.default.password = password-postgres-user # Verify Postgres user password
database.default.DBDriver = Postgre
database.default.DBPrefix =
database.default.port = 5432
```

6 - When executing the migrations, is necessary use the commands to create some populated tables to some selection fields at forms.
```
php spark db:seed

# Following you need specify the seeders (You must specify each one in turn, so is necessary execute php spark db:seed for choose the seeder file)
- TipoHunterSeeder
- TipoNenSeeder
- TipoSanguineoSeeder
```

7 - Execute Apache server.
```
php spark serve
```