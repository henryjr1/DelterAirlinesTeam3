from datetime import datetime
from flask_restful import Resource
from flask import request, render_template, make_response, redirect, url_for
from app.models import *
from app.schemas import *
from app.forms import *


class FlightAPI(Resource):

    def __init__(self):
        self.flight_schema = FlightSchema()
        self.flights_schema = FlightSchema(many=True)

    def get(self):
        """
        Get the flight request from user and return corresponding flight
        :return: flight given id or all available flights if id is not specified
        """
        flight_id = request.args.get('id')
        # print('Flight id = {}'.format(flight_id))
        if flight_id is not None:
            # Get all currently available flights
            flight = Flight.query.get(flight_id)
            result = self.flight_schema.dump(flight)
            # return jsonify(flight.serialize())
            return {'flight': result.data}
        else:
            # return jsonify(flights=[flight.serialize() for flight in Flight.query.all()])
            flights = Flight.query.all()
            # print(flights)
            result = self.flights_schema.dump(flights)
            # print(result.data)
            return {'flights': result.data}


class FlightSearchAPI(Resource):

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

        return make_response(render_template('search_result.html', flights=available_flights), 200)


class TicketAPI(Resource):
    def __init__(self):
        self.tickets_schema = TicketSchema(many=True)

    def get(self):
        flight_id = request.args.get('available')
        if flight_id is None:
            tickets = Ticket.query.all()
        elif flight_id == 'False':
            tickets = Ticket.query.filter(Ticket.available == False).all()
        else:
            tickets = Ticket.query.filter(Ticket.available == True).all()
        # print(tickets)
        result = self.tickets_schema.dump(tickets)
        # print(result.data)
        return {'tickets': result.data}


class OrderAPI(Resource):

    def get(self):
        pass

    def post(self):
        pass

    def put(self):
        pass

    def delete(self):
        pass