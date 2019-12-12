## How to run this project

This project is a test for recruiting on InPhonex:

- start container's service, on root folder do: ``docker-compose up``
- download laravel dependencies: ``docker-compose run app composer create-project``
- create database app: ``docker-compose run database mysql -h database -u root --password=root -e "CREATE DATABASE app;"``
