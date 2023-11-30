
# Laravel 10 Api Base

A brief description of what this project does and who it's for


## Features

- City, State, Country Seeder (more than 150K cities)
- Custom Api Response
- Jwt Auth
- FileUploadService
- oneToMany relationship sync
- Set model table from config/dbtables
- SearchScope, ActiveScope, Ulid (Primary Key)
- Docker


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`APP_KEY=app key` \
`JWT_SECRET=jwt key` \

`DB_CONNECTION=pgsql` \
`DB_HOST=localhost`\
`DB_PORT=5432` \
`DB_DATABASE=tp_pre` \
`DB_USERNAME=postgres` \
`DB_PASSWORD=` \


## Installation

Install my-project with composer\
Requirment php-8.1 or Heigher, Pgsql 14 or Heigher

```bash
  composer install / update
  php artisan key:generate // generate app key
  php artisan jwt:secret // generate jwt key
  setup .env file
  php artisan migrate
  php artisan db:seed
  php artisan serve
  // docker
  docker-compose up
```
    