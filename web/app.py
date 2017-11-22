#!flask/bin/python
from flask_restful import Api
from app import app

from app.views import *
from instance.db_create import init_db
import time
import traceback

api = Api(app, prefix="/api/v1.0")
api.add_resource(FlightListAPI, '/flights')
api.add_resource(FlightAPI, '/flights/<string:flight_id>')
api.add_resource(FlightSearchAPI, '/Flight-Search')
api.add_resource(TicketAPI, '/flights/<string:flight_id>/tickets')
api.add_resource(FlightSearchByDepartingZipCodeAPI, '/flights/departing/<string:zip_code>')
api.add_resource(FlightSearchByArrivingZipCodeAPI, '/flights/arriving/<string:zip_code>')
api.add_resource(OrderAPI, '/order')
api.add_resource(ResetAPI, '/reset')

if __name__ == '__main__':
    dbstatus = False
    while dbstatus == False:
        try:
            init_db()
        except:
            time.sleep(2)
            traceback.print_exc()
        else:
            dbstatus = True

    app.run(debug=True, host="0.0.0.0")