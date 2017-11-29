#!flask/bin/python
from flask_restful import Api
from flask_cors import CORS
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
api.add_resource(FlightSearchByDepartingLocationAPI, '/flights/departing/<string:location>')
api.add_resource(FlightSearchByArrivingLocationAPI, '/flights/arriving/<string:location>')
api.add_resource(OrderAPI, '/purchases/order')
api.add_resource(PurchaseHistoryAPI,'/purchases')
api.add_resource(ResetAPI, '/reset')
api.add_resource(EditTicketPurchase, '/purchases/tickets/<string:ticket_id>')
# api.add_resource(UpdateTicketPurchaser, '/purchases/tickets/<string:ticket_id>/<string:passenger_id>')

gui_api = Api(app)
gui_api.add_resource(FlightSearch, '/Flight-Search')

CORS(app)
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

    app.run(debug=True, host="0.0.0.0", use_reloader=False)