## Description
This is a Laravel project integrated with MySQL database

Deploy: https://trongphan5301.click/

## How to Run the Project

### Requirements
- [Docker](https://www.docker.com/) (installed)

### Running the Project
1. Create and start Docker containers:
    ```bash
    docker-compose up -d --build
    ```
2. In project folder
   ```
    docker-compose exec app composer install
    docker-compose exec app chmod -R 777 .
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan migrate
    ```

3. Access the Laravel project in your web browser:
    ```
    http://localhost:8081
    ```
4. Schedule task(test)
   ```
   docker-compose exec app php artisan schedule:run
   ```
