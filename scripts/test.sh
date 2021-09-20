#!/bin/bash

sleep 3

php artisan migrate
php artisan storage:link
php artisan test
