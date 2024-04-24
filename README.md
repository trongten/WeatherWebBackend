```
docker-compose exec app composer install
docker-compose exec app chmod -R 777 .
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```