#!/usr/bin/env bash


docker-compose up -d --force-recreate

docker exec -i bi bash -c "cd backend && composer install --no-dev && php artisan cache:clear && php artisan config:clear"
docker exec -i bi bash -c "cd frontend && npm i && npm run build "