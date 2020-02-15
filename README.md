# Crazy Dutch Bikers

Repository for the website of Crazy Dutch Bikers

## Commands

* ```docker-compose up -d nginx mysql phpmyadmin selenium``` to start all containers, selenium is for testing
* ```docker-compose exec workspace bash``` to execute bash commands inside the workspace container
* ```npm run dev``` in workspace to compile js and css
* ```php artisan dusk``` runs all tests

## URL's

### App
Url: 127.0.0.1

### PHPmyAdmin
Url: 127.0.0.1:8080
Server: mysql
User: cdb
Password: cdb

### testing
Create a sqlite db called cdb
copy .env.sample to .env.dusk.local and change the values with (testing: ) appended
