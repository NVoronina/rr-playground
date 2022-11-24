#RoadRunner Playground

### Installation
* Install Composer dependencies
``composer install``
* Build and start docker containers
``docker-compose up -d``

### API

Cats list 
``GET http://127.0.0.1:8081/``

Update cat description 
``PUT http://127.0.0.1:8081/
{
    "id": 1,
    "description": "Perfect cat!"
}
``

### Public

http://127.0.0.1:8082/
* List of cats
* Form for adding new cat