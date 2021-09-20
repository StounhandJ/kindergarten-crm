#!/bin/bash

sleep 3

php artisan migrate
php artisan storage:link
vendor/bin/phpunit --coverage-html tests/coverage
