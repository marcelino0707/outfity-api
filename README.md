
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
https://api.postman.com/collections/23319272-98f18018-c383-4f6d-90fd-8ab02f379b97?access_key=PMAT-01H3DSRJW0DP6QPKAQFZ5VTCMD
