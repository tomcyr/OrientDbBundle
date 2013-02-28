OrientDbBundle
==============

Integrates Doctrine OrientDB ODM with Symfony2 with my custom persist and remove methods

## Requirements

* PHP 5.3+
* [Symfony2](http://symfony.com)
* [Doctrine OrientDB ODM](http://www.doctrine-project.org/projects/orientdb-odm.html)

## Installation

### Composer

The preferred way to install this bundle is to rely on [Composer](http://getcomposer.org).

#### Method 1

Simply run assuming you have installed composer.phar or composer binary:

```bash
$ composer require concept-it/orient-db-bundle dev-master
```

### Method 2

1. Add the following lines in your composer.json:

```js
{
  "require": {
    "concept-it/orient-db-bundle": "dev-master"
  }
}
```

2. Run the composer to download the bundle

```bash
$ php composer.phar update concept-it/orient-db-bundle
```

### Add this bundle to your application's kernel

```php
// app/ApplicationKernel.php
public function registerBundles()
{
    return array(
        // ...
        new ConceptIt\OrientDbBundle\ConceptItOrientDbBundle(),
        // ...
    );
}
```

## Configuration

```yml
# app/config/config.yml
concept_it_orient_db:
    host:               "127.0.0.1"
    port:               2480
    user:               "user"
    password:           "password"
    dbname:             "dbname"
    proxy_dir:          "%kernel.root_dir%/cache"
    domain_dir:         "%kernel.root_dir%/../src/YourBundle/Entity"
    domain_namespace:   "YourBundle\Entity"
```

## Authors

Tomasz Cyrankowski - <tomek@concept-it.pl>

## License

OrientDbBundle is licensed under the MIT License - see the [LICENSE file](https://github.com/tomcyr/OrientDbBundle/blob/master/LICENSE) for details
