#!/bin/bash
cd /app/web
npm install
npm i bower -g
cd /app
composer install
php-fpm --nodaemonize