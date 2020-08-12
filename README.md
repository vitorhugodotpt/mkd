## Instalation

### Local (via artisan serve)
* clone repository
* run ``` cd mkd ```
* run ``` cp .env.example .env ```
* run ``` php artisan key:generate ```
* edit .env file 
* run ``` php artisan migrate --seed ```
* run ``` php artisan serve --host=localhost --port=8000 ```
* goto ``` http://localhost:8000 ```

### Local (via Docker)
* clone repository
* run ``` cd mkd ```
* run ``` cp .env.example .env ```
* run ``` php artisan key:generate ```
* edit .env file 
* .env database 
``` 
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```
* run ``` docker-compose up -d ```
* run ``` php artisan migrate --seed ```
* run ``` docker exec -it app bash ```

## Routes
Available routes

| URL | Description |
|---|:---:|
| / | Home |
| /login | Login |
| /dashboard | Dashboard |
| /:project_hash | Quiz form |

:project_hash : hash value in project table

