from datetime import datetime
from flask_restful import Resource, abort
from flask import request, render_template, make_response, jsonify
from app.models import *
from app.schemas import *
from app.forms import *
from instance.db_create import init_db


class FlightListAPI(Resource):

    def __init__(self):
        self.flight_schema = FlightSchema(many=True)

    def get(self):
        flights = Flight.query.all()
        result = self.flight_schema.dump(flights)
        return {'flights': result.data}

def abort_if_todo_doesnt_exist(flight_id):
    flight = Flight.query.get(flight_id)
    if flight is None:
        abort(404, message="Flight {} doesn't exist".format(flight_id))

class FlightAPI(Resource):

    def __init__(self):
        self.flight_schema = FlightSchema()

    def get(self, flight_id):
        """
        Get the flight request from user and return corresponding flight
        :return: flight given id or all available flights if id is not specified
        """
        flight = Flight.query.get(flight_id)
        if flight is not None:
            result = self.flight_schema.dump(flight)
            return {'flight': result.data}
        else:
            abort_if_todo_doesnt_exist(flight_id)


class FlightSearchAPI(Resource):

    def __init__(self):
        self.flight_schema = FlightSchema(many=True)

    def get(self):
        """
        /inventory?startDate=2017-11-14T00:00&endDate=2017-11-14T23:59&location=Starkville,%20MS

        :return:
        """
        args = request.args
        if len(args) == 0:
            form = FlightSearchForm(request.form)
            headers = {'Content-Type': 'text/html'}
            return make_response(render_template('flight_search.html', form=form), 200, headers)

        from_location = args['fromLocation']
        to_location = args['toLocation']
        startDate = args['startDate']
        endDate = args['endDate']

        startDate = datetime.strptime(startDate, '%Y-%m-%d')
        endDate = datetime.strptime(endDate, '%Y-%m-%d')

        available_flights = Flight.query.filter(Flight.source == from_location,
                                                Flight.destination == to_location,
                                                Flight.departure_time >= startDate,
                                                Flight.arrival_time >= endDate)
        result = self.flight_schema.dump(available_flights)
        return {'flights': result.data}
        # return make_response(render_template('search_result.html', flights=available_flights), 200)


class TicketAPI(Resource):
    def __init__(self):
        self.tickets_schema = TicketSchema(many=True)

    def get(self, flight_id):
        """
        Get all available tickets given flight id
        """

        tickets = Ticket.query.filter_by(flight_id=flight_id).filter_by(available=True)
        if tickets is not None:
            result = self.tickets_schema.dump(tickets)
            # print(result.data)
            return {'tickets': result.data}


class OrderAPI(Resource):

    def get(self):
        form = PlaceOrderForm(request.form)
        return make_response(render_template('order_ticket.html', form=form), 200, {'Content-Type': 'text/html'})

    def post(self):
        pass

    def put(self):
        pass

    def delete(self):
        pass


class ResetAPI(Resource):
    """
    Reset database to the original data for testing purpose
    """
    def get(self):
        init_db()
        return jsonify({"Message":"Reset successfully!"})
