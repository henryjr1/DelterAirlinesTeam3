'''
#--------------------------------------#
Generate sample database for the web app
#--------------------------------------#
'''


from app.models import *
import datetime
import random

# create the database table and make-up data

def init_db():
    print('Start creating database...')
    db.drop_all()
    db.create_all()

    # insert user data
    passenger1 = Passenger(name='Bob', dob=datetime.date(1994, 4, 16), email='bob@cse.msstate.edu', address='Butler Hall')
    passenger2 = Passenger(name='Alice', dob=datetime.date(1954, 3, 25), email='alice@cse.msstate.edu',
                           address='Butler Hall')
    passenger3 = Passenger(name='Jack', dob=datetime.date(1976, 6, 23), email='jack@cse.msstate.edu', address='Butler Hall')
    # add to session
    db.session.add(passenger1)
    db.session.add(passenger2)
    db.session.add(passenger3)

    # insert plane data
    plane1 = Plane(model='Boeing 747', capacity=56, flight_number='BOEING_123')
    plane2 = Plane(model='Airbus 322', capacity=74, flight_number='AIRBUS_435')
    plane3 = Plane(model='SpaceX 543', capacity=32, flight_number='SPACEX_653')
    # add to session
    db.session.add(plane1)
    db.session.add(plane2)
    db.session.add(plane3)

    # insert flight data
    # generate random departure and arrival time
    departure_datetimes = []
    arrival_datetimes = []

    minutes = [minute for minute in range(0, 60, 5)]
    now = datetime.datetime.now()
    for i in range(3):
        departure_hour = random.randint(1, 23)
        departure_minute = random.choice(minutes)
        departure_day = random.randint(now.day, 30)
        departure_month = random.randint(now.month, 12)
        departure_year = now.year
        departure_datetime = datetime.datetime(departure_year, departure_month, departure_day, departure_hour,
                                               departure_minute, 0)

        arrival_hour = random.randint(1, 23)
        arrival_minute = random.choice(minutes)
        arrival_day = random.randint(now.day, 30)
        if arrival_day > departure_day:
            arrival_month = departure_month
        else:
            arrival_month = departure_month + 1 if departure_month < 12 else 1
        arrival_year = now.year
        arrival_datetime = datetime.datetime(arrival_year, arrival_month, arrival_day, arrival_hour, arrival_minute, 0)

        departure_datetimes.append(departure_datetime)
        arrival_datetimes.append(arrival_datetime)

    flight1 = Flight(source='GTR', destination='Atlanta', locale='Starkville', departure_time=departure_datetimes[0], arrival_time=arrival_datetimes[0])
    flight1.plane = plane1

    flight2 = Flight(source='Chicago', destination='New York', locale='Starkville', departure_time=departure_datetimes[1], arrival_time=arrival_datetimes[1])
    flight2.plane = plane2

    flight3 = Flight(source='LAX', destination='Philadelphia', locale='Atlanta', departure_time=departure_datetimes[2], arrival_time=arrival_datetimes[2])
    flight3.plane = plane3

    # add to session
    db.session.add(flight1)
    db.session.add(flight2)
    db.session.add(flight3)

    # commit the changes
    db.session.commit()

    print('Finish creating database....')