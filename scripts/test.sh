#!/bin/bash

sleep 3

php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan test
