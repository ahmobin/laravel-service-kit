# Laravel Service Kit

This package provides a set of commands to quickly generate service, interface, and repository classes in your Laravel application.

## Installation

Install the package via Composer:

```bash
composer require ahmobin/laravel-service-kit
```

#### Register Service Provider:
```bash
'providers' => [
    // Other Service Providers
    \Mobin\LaravelServiceKit\LaravelServiceKitServiceProvider::class,
],
```

### Usages:

###### Creating a Service Class
To create a service class, run the following command:
```bash
php artisan make:service YourClassNameService
```

###### Creating an Interface Class
To create an interface class, run the following command:
```bash
php artisan make:interface YourClassNameInterface
```

###### Creating a Repository Class
To create a repository class, run the following command:
```bash
php artisan make:repo YourClassNameRepository
```

Further you may bind the repository class with interface in your AppServiceProvider

Feel free to customize the class names as per your application's naming conventions.
