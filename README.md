# phriendly-dependencies

A tool to check if you are accessing dependencies you should not have access to.

At the moment it checks that you are using, in the `use` clauses at the
beginning of your files, only classes which are contained in a namespace exposed
by your own library or by a dependency explicitely declared in your
`composer.json`.

In other words, this tool notifies you if you are using directly classes
belonging to packages that are not first dependencies of your own library.

This is to avoid that changes in the dependencies of your dependencies could
generate errors in your library.

## composer

Install dependencies using

```bash
composer install
```

If you are using Docker you could use

```bash
docker run --rm -ti -v $(pwd):/app -u $(id -u):$(id -g) -e "COMPOSER_HOME=/tmp/composer" composer install
```
## run

Run the program with

```bash
php bin/phd.php -p $PATH_YOU_WANT_TO_ANALYZE
```

If you are using Docker you could use

```bash
docker run --rm -ti -v $(pwd):/app php:7.1 php /app/bin/phd.php -p $PATH_YOU_WANT_TO_ANALYZE
```

## test

Run the tests with

```bash
php vendor/bin/phpunit
```

If you are using Docker you could use

```bash
docker run --rm -ti -v $(pwd):/app php:7.1 php /app/vendor/bin/phpunit -c /app/phpunit.xml
```
