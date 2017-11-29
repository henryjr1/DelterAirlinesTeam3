# views.py
from flask_restful import Resource, abort, reqparse
from flask import request, render_template, make_response, jsonify, redirect

from datetime import datetime
from app.models import *
from app.schemas import *
from app.forms import *
from instance.db_create import init_db

# This is a YYYY-MM-DDTHH:mm:ss format using 24-hour
# time and leading zeros (e.g. “2017-09-03T15:04:00”)

DATE_TIME_FORMAT = '%Y-%m-%dT%H:%M:%S'
DATE_OF_BIRTH_FORMAT = '%Y-%m-%d'


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
        self.parser = reqparse.RequestParser()
        self.parser.add_argument('startDate')
        self.parser.add_argument('endDate')

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

    def put(self, flight_id):
        """
        Update flight's departing time and arriving time
        """
        updated_flight = Flight.query.get(flight_id)
        if updated_flight is None:
            return {'Message': 'Flight with id = {} is not available!'.format(flight_id)}, 404

        args = self.parser.parse_args()
        updated_start_date = args['startDate']
        updated_end_date = args['endDate']

        # Catch exception and return error message to user
        # if updated datetime don't follow specified format
        try:
            updated_start_date = datetime.strptime(updated_start_date, DATE_TIME_FORMAT)
            updated_end_date = datetime.strptime(updated_end_date, DATE_TIME_FORMAT)
        except ValueError:
            return {'Error': 'Updated datetime should follow format YYYY-MM-DDTHH:mm:ss'}, 400

        # data is valid. Update record in database
        updated_flight.departure_time = updated_start_date
        updated_flight.arrival_time = updated_end_date
        db.session.commit()

        result = self.flight_schema.dump(updated_flight)
        return {'flight': result.data}


class FlightSearchAPI(Resource):

    def __init__(self):
        self.flight_schema = FlightSchema(many=True)

    def get(self):
        """
        /inventory?startDate=2017-11-14T00:00&endDate=2017-11-14T23:59&location=Starkville,%20MS

        :return:
        """
        available_flights = self.get_available_flight(request.args)
        result = self.flight_schema.dump(available_flights)
        return {'flights': result.data}

    def get_available_flight(self, args):
        """
        :return: a list of available flight given search queries
        """
        if len(args) == 0:
            return []
        from_location = args['fromLocation']
        to_location = args['toLocation']
        start_date = datetime.strptime(args['startDate'], '%Y-%m-%d')
        end_date = datetime.strptime(args['endDate'], '%Y-%m-%d')

        available_flights = Flight.query.filter(Flight.source == from_location,
                                                Flight.destination == to_location,
                                                Flight.departure_time >= start_date,
                                                Flight.arrival_time >= end_date)

        return available_flights

class FlightSearch(FlightSearchAPI):
    def __init__(self):
        super().__init__()

    def get(self):
        args = request.args
        if len(args) == 0:
            form = FlightSearchForm(request.form)
            headers = {'Content-Type': 'text/html'}
            return make_response(render_template('flight_search.html', form=form), 200, headers)

        available_flights = self.get_available_flight(args)
        return make_response(render_template('search_result.html', flights=available_flights), 200)

class FlightSearchByDepartingLocationAPI(Resource):
    """
    Search available flights by departing zip code
    """
    def __init__(self):
        self.flight_schema = FlightSchema(many=True)

    def get(self, location):
        flights = Flight.query.filter(Flight.source==location)
        result = self.flight_schema.dump(flights)
        return {'flights': result.data}

class FlightSearchByArrivingLocationAPI(Resource):
    """
    Search available flights by arriving zip code
    """
    def __init__(self):
        self.flight_schema = FlightSchema(many=True)

    def get(self, location):
        flights = Flight.query.filter(Flight.destination==location)
        result = self.flight_schema.dump(flights)
        return {'flights': result.data}


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
    """
    + Place an order
    + Cancel an order
    """

    def __init__(self):
        self.parser = reqparse.RequestParser()
        self.parser.add_argument('ticketID') # ticket id
        self.parser.add_argument('name')     # customer name
        self.parser.add_argument('dob')      # date of birth
        self.parser.add_argument('email')    # email
        self.parser.add_argument('address')  # address

    def get(self):
        form = PlaceOrderForm(request.form)
        return make_response(render_template('order_ticket.html', form=form), 200, {'Content-Type': 'text/html'})

    def post(self):
        args = self.parser.parse_args()
        ticket_id = args['ticketID']
        name = args['name']
        dob = args['dob']
        email = args['email']
        address = args['address']

        bought_ticket = Ticket.query.get(ticket_id)

        if bought_ticket == None:
            return {'Error:': 'Ticket of id {} does not exist!'.format(ticket_id)}, 404

        if bought_ticket.available == False:
            return {'Info': 'Selected ticket is unavailable!'}, 200
        else:
            try:
                dob = datetime.strptime(dob, DATE_OF_BIRTH_FORMAT)
            except ValueError:
                return {'Error': 'Date of birth format is incorrect!'}, 400

            bought_ticket.available = False
            passenger = Passenger(name=name, dob=dob, email=email, address=address)
            transaction = Transaction(passenger=passenger, ticket=bought_ticket)

            db.session.add(transaction)
            db.session.commit()

            return redirect('/api/v1.0/purchases', 201)

    def put(self):
        pass

    def delete(self):
        pass

class PurchaseHistoryAPI(Resource):

    def __init__(self):
        self.transaction_schema = TransactionSchema(many=True)

    def get(self):
        revenue = 0.0
        transactions = Transaction.query.all()
        for transaction in transactions:
            revenue += transaction.ticket.price
        result = self.transaction_schema.dump(transactions)
        return {'purchase_history': {
                    'total_revenue': '${:,.2f}'.format(revenue),
                    'purchases': result.data}}


class ResetAPI(Resource):
    """
    Reset database to the original data for testing purpose
    """
    def get(self):
        init_db()
        return jsonify({"Message":"Reset successfully!"})

class EditTicketPurchase(Resource):

    def __init__(self):
        self.passenger_schema = PassengerSchema()
        self.parser = reqparse.RequestParser()
        self.parser.add_argument('name')

    #
    def delete(self, ticket_id):
        """
        Deletes ticket id from transaction table and changes it status to available in ticket table
        :param ticket_id: ticket id
        """

        '''
        ticket_ids = []
        transactions = Transaction.query.all()
        for transaction in transactions:
            ticket_ids += [transaction.ticket.id]
        if (int(ticket_id) in ticket_ids):
            ticket_column = Ticket.query.filter_by(id=ticket_id).first()
            ticket_column.available = True
            transaction_column = Transaction.query.filter_by(ticket_id=ticket_id).first()
            db.session.delete(transaction_column)
            db.session.commit()
            return jsonify({"Message":"Ticket purchase cancelled succesfully!"})
        '''
        transaction = Transaction.query.filter(Transaction.ticket_id == ticket_id).first()
        if transaction is not None:
            # TODO: Might need to consider if ticket has expired or not
            # But for simplicity, ignore that case
            ticket = transaction.ticket
            ticket.available = True
            db.session.delete(transaction)
            db.session.commit()
        else:
            return {'Error:': 'Ticket of id {} does not exist or has not been purchased yet!'.format(ticket_id)}, 404

    #Returns the user information for a particular ticket id
    def get(self, ticket_id):
        '''
        ticket_ids = []
        transactions = Transaction.query.all()
        for transaction in transactions:
            ticket_ids += [transaction.ticket.id]
        if (int(ticket_id) in ticket_ids):
            transaction_column = Transaction.query.filter_by(ticket_id=ticket_id)
            result = self.transaction_schema.dump(transaction_column)
            return {"Purchaser Info": result.data}

        else:
            return {'Error:': 'Ticket of id {} does not exist or has not been purchased yet!'.format(ticket_id)}, 404
        '''

        transaction = Transaction.query.filter(Transaction.ticket_id==ticket_id).first()
        if transaction is not None:
            passenger = transaction.passenger
            result = self.passenger_schema.dump(passenger)
            return {'Passenger': result.data}, 200
        else:
            return {'Error:': 'Ticket of id {} does not exist or has not been purchased yet!'.format(ticket_id)}, 404

    def put(self, ticket_id):
        """
        Update passenger's name
        :param ticket_id: ticket id
        """
        transaction = Transaction.query.filter(Transaction.ticket_id == ticket_id).first()
        if transaction is not None:
            args = self.parser.parse_args()
            new_name = args['name']
            if new_name is None or new_name == '': # No input, no update
                return {'Message':'No input. User information stay the same!'}
            else:
                # Update passenger's name
                # TODO: Might allow options to update other information as well.
                passenger = transaction.passenger
                passenger.name = new_name
                db.session.commit()
                return {'Passenger': self.passenger_schema.dump(passenger).data}, 200
        else:
            return {'Error:': 'Ticket of id {} does not exist or has not been purchased yet!'.format(ticket_id)}, 401


'''
class UpdateTicketPurchaser(Resource):

    def __init__(self):
        self.transaction_schema = TransactionSchema(many=True)

    #Updates the passenger id of a particular ticket purchase
    def put(self, ticket_id, passenger_id):
        ticket_ids = []
        passenger_ids = []
        transactions = Transaction.query.all()
        passenger = Passenger.query.all()
        for transaction in transactions:
            ticket_ids += [transaction.ticket.id]
        for passenger in passenger:
            passenger_ids += [passenger.id]
        if (int(ticket_id) in ticket_ids and int(passenger_id) in passenger_ids):
            transaction_column = Transaction.query.filter_by(ticket_id=ticket_id).update(dict(passenger_id=int(passenger_id)))
            db.session.commit()
            return jsonify({"Message":"Ticket purchaser succesfully updated!"})
        elif (int(passenger_id) not in passenger_ids):
            return {'Error:': 'Passenger of id {} does not exist!'.format(passenger_id)}, 404        
        else:
            return {'Error:': 'Ticket of id {} does not exist or has not been purchased yet!'.format(ticket_id)}, 404
'''
