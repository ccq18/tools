#!/usr/bin/env bash

chmod -R 777 storage;
(
cd docker;
docker-compose  -p laravel  stop;
docker-compose -p laravel up --build -d;
docker system prune -f;
)