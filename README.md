# php-friendly-dependencies
A tool to check if you are accessing dependencies you should not have access to

## composer

Install dependencies using

```bash
docker run --rm -ti -v $(pwd):/app -u $(id -u):$(id -g) -e "COMPOSER_HOME=/tmp/composer" composer
```
## run

Run the program with

```bash
docker run --rm -ti -v $(pwd):/app php:7.1 php /app/src/fdc.php
```
