#!/bin/bash

sleep 10
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan queue:work --name=Test --sleep=20 --rest=20 --tries=3 --backoff=5 --timeout=10 -q &
service cron start

php-fpm
