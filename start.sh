#!/usr/bin/env bash
docker-compose stop
rm -rf docker_data/mysql/db_data/* app/node_modules app/vendor
docker-compose build
docker-compose up -d