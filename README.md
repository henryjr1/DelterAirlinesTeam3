# delter-airlines-reservation
Implement prototype for online flight reservations website with RESTful APIs

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites
* Python 3.6
* Postgresql 10.0
* Install [docker](https://docs.docker.com/engine/installation/) (No need to install Python or Postgresql)

Can run without docker installed but highly recommend to make thing easer.

### Installing

A step by step series of examples that tell you have to get a development env running

Say what the step will be

1. Clone project at with ```git clone```.
```
    git clone https://github.com/henryjr1/DelterAirlinesTeam3.git
```
2. Create .env file at the root of project

```
    POSTGRES_USER='your-postgres-user'
    POSTGRES_PASSWORD='your-password'
    POSTGRES_DB='your-db'
```

3. Update corresponding information in configuration file at web/instance/flask.cfg
```
    POSTGRES_USER = 'your-postgres-user'
    POSTGRES_PASSWORD = 'your-password'
    POSTGRES_DB = 'your-db'
    HOST = 'database'  # This should not change. This is a service in docker-compose.yaml
```

## Deployment
```
docker-compose build  ---  build the image
docker-compose -d     ---  run the container on background and build image if necessary
```

Now open your browser and try the url http://localhost:5000/api/v1.0/flights. It should return something like this
```
{
    "flights": [
        {
            "id": 1,
            "fromLocation": "GTR",
            "toLocation": "Atlanta",
            "plane_id": 1,
            "plane": {
                "id": 1,
                "model": "Boeing 747",
                "capacity": 56,
                "flight_number": "BOEING_123"
            },
            "startDate": "2017-12-24T06:30:00+00:00",
            "endDate": "2017-01-20T11:40:00+00:00"
        },
        {
            "id": 2,
            "fromLocation": "Chicago",
            "toLocation": "New York",
            "plane_id": 2,
            "plane": {
                "id": 2,
                "model": "Airbus 322",
                "capacity": 74,
                "flight_number": "AIRBUS_435"
            },
            "startDate": "2017-11-27T02:20:00+00:00",
            "endDate": "2017-12-20T15:40:00+00:00"
        },
        {
            "id": 3,
            "fromLocation": "LAX",
            "toLocation": "Philadelphia",
            "plane_id": 3,
            "plane": {
                "id": 3,
                "model": "SpaceX 543",
                "capacity": 32,
                "flight_number": "SPACEX_653"
            },
            "startDate": "2017-12-18T04:40:00+00:00",
            "endDate": "2017-12-27T19:30:00+00:00"
        }
    ]
}
```
## APIs
Find the list of APIs at [Swagger](https://app.swaggerhub.com/apis/DelterArlines/DelterAirlinesAPI/1.0.0).


## Built With
* [Flask](http://flask.pocoo.org/]) - Python web development microframework
* [Flask-Restful](https://flask-restful.readthedocs.io/en/latest/) - adds support for quickly building REST APIs
* [Jinga2](http://jinja.pocoo.org/docs/2.10/) - templating engine
* [SQLAlchemy](https://www.sqlalchemy.org/) - ORM (Object Relational Mapper), mapping python objects to tables in database
* [Flask-Migrate](https://flask-migrate.readthedocs.io/en/latest/) - database migrations
* [Flask-WTF](https://flask-wtf.readthedocs.io/en/stable/) - simplifies forms

## Authors

* **Anh Do** - [aqd14](https://github.com/aqd14)
* **Will Nobles**
* **Will Lee**
* **Dalton Weeb**
* **Patrick Bourdeaux**

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments
N/A
