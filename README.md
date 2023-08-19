This package provides [php-cs-fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) configuration applied in [Axa Zara](https://axazara.com/) PHP projects.
This represents the standard code style applied within Axa Zara's PHP project.## Quickstart

### Step 1 of 3

Install the package via Composer:

```sh
composer require --dev axazara/php-cs
```

### Step 2 of 3

Once package installed, a file `.php-cs-fixer.dist.php` will be created at the root of your project with the following contents:

```php
<?php

use AxaZara\CS\Finder;
use AxaZara\CS\Config;

// Routes for analysis with `php-cs-fixer`
$routes = ['./src', './tests'];

return Config::createWithFinder(Finder::createWithRoutes($routes));
```

Change the value of `$routes` depending on where your project's source code is.

### Step 3 of 3

**And that's it!** You can now find code style violations with the following command:

```sh
./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --dry-run
```

And then completely fix them all with:

```sh
./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

## Configuration

You must pass a set of routes to the `Finder::createWithRoutes()` call. For example, for [Laravel](https://laravel.com) projects, this would be:

```php
Finder::createWithRoutes(['./app', './config', './database', './resources', './routes', './tests'])
```

Also, you can pass a custom set of rules to the `Config::createWithFinder()` call:

```php
Config::createWithFinder($finder, [
    '@PHP81Migration'   => true,
    'array_indentation' => false
])
```

## License

This is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).

## Special thanks

- https://github.com/FriendsOfPHP/PHP-CS-Fixer
- https://mlocati.github.io/php-cs-fixer-configurator/
- https://github.com/gomzyakov/php-cs-fixer-config