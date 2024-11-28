## Introduction
About this project.

## Project structure
-

## Deploy
Install docker engine, as detailed on [docker.com - Docker Engine Install](https://docs.docker.com/engine/install/ubuntu/#install-using-the-repository). You may need to ues `sudo` to run the docker commands.

Then on the project root:
```
# Copy default credential values. You can optionally set your own on `.env`.
cp .env.example .env
cp appserver_laravel/src/.env.example appserver_laravel/src/.env

sudo chown -R www-data: appserver_laravel/src
sudo docker compose exec appserver_laravel npm install
sudo docker compose exec appserver_laravel php artisan key:generate
sudo docker compose exec appserver_laravel php artisan migrate
```

### Dev
```
docker compose -f compose.dev.yaml up -d
sudo docker compose exec -it appserver_laravel npm run dev -- --host
```

### Prod
Add SSL certificate files for domain in `certs/`
```
docker compose up -d
sudo docker compose exec -it appserver_laravel npm run build
```
