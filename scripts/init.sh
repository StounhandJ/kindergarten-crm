#!/bin/bash

sleep 10
php artisan migrate
php artisan db:seed
php artisan storage:link
