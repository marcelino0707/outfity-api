
## Setup
1. `cp .env.example .env`
2. adjust database environment
	```
	DB_HOST=db / 127.0.0.1
	DB_PORT=3306
	DB_DATABASE=outfity
	DB_USERNAME=~~yourusername~~
	DB_PASSWORD=~~yourpassword~~
	```

## Run in local environment 
1. `composer install`
2. `php artisan key:generate`
3. `php artisan migrate:fresh --seed`
4. `php artisan jwt:secret`
5. `php artisan serve`

## Postman Collection
import postman collection from this link
https://docs.google.com/document/d/1D6tGLqxejL1lK0CAeKWxF6kukRWQnjXdKD1oWVQwoCU/edit?usp=sharing

## Documentation 
https://docs.google.com/document/d/1freK00LiV-1zqUPjCjtgPhyFqDdKwI7q_POh8U27xbM/edit?usp=sharing

