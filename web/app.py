#!flask/bin/python
from flask_restful import Api
from app import app

from app.views import FlightAPI, FlightSearchAPI
from instance.db_create import init_db

api = Api(app, prefix="/api/v1.0")
api.add_resource(FlightAPI, '/flights')
api.add_resource(FlightSearchAPI, '/Flight-Search')

if __name__ == '__main__':
    init_db()
    app.run(debug=True, host="0.0.0.0")