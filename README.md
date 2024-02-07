# CodeIgniter 4 Application Starter

## How to start?

Advice: To get commands of CodeIgniter framework use this command:
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

3 - Run the following command to generate `encryption.key` value of `.env`.
```
php spark key:generate
```

4 - Change the following informations in `.env` (I'm using Linux distro like my operating system).
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

5 - When executing the migrations, is necessary use the commands to create some populated tables to some selection fields at forms.
```
php spark db:seed

# Following you need specify the seeders (You must specify each one in turn, so is necessary execute php spark db:seed for choose the seeder file)
- TipoHunterSeeder
- TipoNenSeeder
- TipoSanguineoSeeder
```

6 - Execute Apache server.
```
php spark serve
```