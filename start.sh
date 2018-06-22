#!/usr/bin/env bash

chmod -R 777 storage;
(
cd docker;
docker-compose  -p service  stop;
docker-compose -p service up --build -d;
docker system prune -f;
)