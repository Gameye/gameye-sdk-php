#!/bin/sh

set -e

./vendor/bin/php-cs-fixer fix --dry-run --using-cache=no --stop-on-violation --diff .
./vendor/bin/phpunit
