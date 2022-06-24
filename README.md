# LARAVEL MODEL
A package to implement repository pattern for laravel models.

### Install Command
```php
composer require aditamairhamdev/lara-model
```

### HOW TO USE 
you can run this command on your terminal. default connection use mysql
```php
php artisan make:lara-model <your_table_name>
```

### WITH ANOTHER CONNECTION
```php
php artisan make:lara-model <your_table_name> --connection=<connection_db>
```
example:
```php
php artisan make:lara-model book --connection=pgsql
```