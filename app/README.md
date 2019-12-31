## How to run this project

This project is a test for recruiting on InPhonex:

- start container's service, on root folder do: ``docker-compose up``
- download laravel dependencies: ``docker-compose run app composer create-project``
- create database app: ``docker-compose run database-mysql -h database -u root --password=root -e "CREATE DATABASE app;"``
- set application key: ``php artisan key:generate``
- rename `.env.example` to `.env`

## Get my Postman api [collection](https://www.getpostman.com/collections/70be61b218cbe63730f4)

see https://www.getpostman.com/
