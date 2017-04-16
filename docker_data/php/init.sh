#!/bin/bash
cd /app/web
#npm install
npm i bower -g
cd /app
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer install
php-fpm --nodaemonize