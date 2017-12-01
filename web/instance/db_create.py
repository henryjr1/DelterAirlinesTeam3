'''
#--------------------------------------#
Generate sample database for the web app
#--------------------------------------#
'''

from app.models import *
from app.common.util import generate_random_ticket, generate_random_flight_dates
import datetime
import random

# create the database table and make-up data

# LOCATION = {'Starkville':'Starkville, MS', 'Atlanta':'Atlanta, GA'}

STARKVILLE_LOCALE = 'Starkville, MS'
ATLANTA_LOCALE = 'Atlanta, GA'

ZIP_CODE = {STARKVILLE_LOCALE : 39759, ATLANTA_LOCALE : 30301}


def init_db():
    print('Start creating database...')
    db.drop_all()
    db.create_all()

    # insert user data
    passenger1 = Passenger(name='Bob', dob=datetime.date(1994, 4, 16), email='bob@cse.msstate.edu',
                           address='Butler Hall')
    passenger2 = Passenger(name='Alice', dob=datetime.date(1954, 3, 25), email='alice@cse.msstate.edu',
                           address='Butler Hall')
    passenger3 = Passenger(name='Jack', dob=datetime.date(1976, 6, 23), email='jack@cse.msstate.edu',
                           address='Butler Hall')
    # add to session
    db.session.add(passenger1)
    db.session.add(passenger2)
    db.session.add(passenger3)

    # insert plane data
    plane1 = Plane(model='Boeing 747', capacity=54, flight_number='BOEING_123')
    tickets1 = generate_random_ticket(plane1.capacity)
    tickets11 = generate_random_ticket(plane1.capacity)
    # plane1.tickets.extend(tickets1)

    plane2 = Plane(model='Airbus 322', capacity=72, flight_number='AIRBUS_435')
    tickets2 = generate_random_ticket(plane2.capacity)
    tickets22 = generate_random_ticket(plane2.capacity)
    # plane2.tickets.extend(tickets2)

    plane3 = Plane(model='SpaceX 543', capacity=36, flight_number='SPACEX_653')
    tickets3 = generate_random_ticket(plane3.capacity)
    tickets33 = generate_random_ticket(plane3.capacity)
    # plane3.tickets.extend(tickets3)

    # add to session
    db.session.add(plane1)
    db.session.add(plane2)
    db.session.add(plane3)

    # insert flight data
    # generate random departure and arrival time
    num_flights = 6
    departure_datetimes, arrival_datetimes = generate_random_flight_dates(num_flights)

    flight1 = Flight(source=STARKVILLE_LOCALE, destination=ATLANTA_LOCALE, locale=STARKVILLE_LOCALE, departure_time=departure_datetimes[0],
                     departure_zip_code=ZIP_CODE[STARKVILLE_LOCALE],
                     arrival_time=arrival_datetimes[0], arrival_zip_code=ZIP_CODE[ATLANTA_LOCALE], tickets=tickets1)
    flight1.plane = plane1

    flight2 = Flight(source=STARKVILLE_LOCALE, destination=ATLANTA_LOCALE, locale=STARKVILLE_LOCALE, departure_time=departure_datetimes[1],
                     departure_zip_code=ZIP_CODE[STARKVILLE_LOCALE],
                     arrival_time=arrival_datetimes[1], arrival_zip_code=ZIP_CODE[ATLANTA_LOCALE], tickets=tickets2)
    flight2.plane = plane2

    flight3 = Flight(source=STARKVILLE_LOCALE, destination=ATLANTA_LOCALE, locale=STARKVILLE_LOCALE, departure_time=departure_datetimes[2],
                     departure_zip_code=ZIP_CODE[STARKVILLE_LOCALE],
                     arrival_time=arrival_datetimes[2], arrival_zip_code=ZIP_CODE[ATLANTA_LOCALE], tickets=tickets3)
    flight3.plane = plane3

    flight4 = Flight(source=ATLANTA_LOCALE, destination=STARKVILLE_LOCALE, locale=ATLANTA_LOCALE,
                     departure_time=departure_datetimes[3],
                     departure_zip_code=ZIP_CODE[ATLANTA_LOCALE],
                     arrival_time=arrival_datetimes[3], arrival_zip_code=ZIP_CODE[STARKVILLE_LOCALE], tickets=tickets11)
    flight4.plane = plane1

    flight5 = Flight(source=ATLANTA_LOCALE, destination=STARKVILLE_LOCALE, locale=ATLANTA_LOCALE,
                     departure_time=departure_datetimes[4],
                     departure_zip_code=ZIP_CODE[ATLANTA_LOCALE],
                     arrival_time=arrival_datetimes[4], arrival_zip_code=ZIP_CODE[STARKVILLE_LOCALE], tickets=tickets22)
    flight5.plane = plane2

    flight6 = Flight(source=ATLANTA_LOCALE, destination=STARKVILLE_LOCALE, locale=ATLANTA_LOCALE,
                     departure_time=departure_datetimes[5],
                     departure_zip_code=ZIP_CODE[ATLANTA_LOCALE],
                     arrival_time=arrival_datetimes[5], arrival_zip_code=ZIP_CODE[STARKVILLE_LOCALE], tickets=tickets33)
    flight6.plane = plane3

    # add to session
    db.session.add(flight1)
    db.session.add(flight2)
    db.session.add(flight3)
    db.session.add(flight4)
    db.session.add(flight5)
    db.session.add(flight6)


    # randomly create sample transactions
    created_transaction = 0
    passengers = [passenger1, passenger2, passenger3]
    while (created_transaction < 50):
        selected_ticket_set = random.randint(1, 6)
        if selected_ticket_set == 1:
            ticket = random.choice(tickets1)
        elif selected_ticket_set == 2:
            ticket = random.choice(tickets2)
        elif selected_ticket_set == 3:
            ticket = random.choice(tickets3)
        elif selected_ticket_set == 4:
            ticket = random.choice(tickets11)
        elif selected_ticket_set == 5:
            ticket = random.choice(tickets22)
        elif selected_ticket_set == 6:
            ticket = random.choice(tickets33)
        else:
            raise ValueError('Invalid ticket')


        if ticket.available == False:
            continue

        # booked_datetime = random.choice(departure_datetime)
        ticket.available = False
        transaction = Transaction(passenger=random.choice(passengers), ticket=ticket)
        db.session.add(transaction)
        created_transaction += 1

    # commit the changes
    db.session.commit()

    print('Finish creating database....')
