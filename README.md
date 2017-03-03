# Sample Rest

The only purpose of this project is to create a simple and fast service to perform tests.

The project is created in [Lumen](https://lumen.laravel.com)

DB Used: [AndroidHive](http://api.androidhive.info/json/movies.json)

DEMO: [Heroku](https://shrouded-savannah-22718.herokuapp.com/api/movies)

## Routes

| METHOD | ROUTE|PARAMS|
|:--------:|:---|:-----|
|GET     |/api/movies||
|POST    |/api/movies/create|id, title, image, rating, releaseYear, genre|
|GET     |/api/movies/{id}|id|
|PUT     |/api/movies/{id}|id, title, image, rating, releaseYear, genre|
|DELETE  |/api/movies/{id}|id|
|POST    |/api/users/login|{username or email}, password|

## Usage

Clone repository

```shell
git clone https://github.com/normeno/sample-rest.git
```

Enter the repository and run test server

```shell
cd sample-rest
php -S localhost:8000 -t public
```