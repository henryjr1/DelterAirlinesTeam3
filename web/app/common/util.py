# util.py

import string
import random
import datetime
from app.models import Ticket

plane_rows = string.ascii_uppercase
avaliability = [True, False]
prices = [230.0, 135.0, 350.0, 75, 85, 125]

def generate_random_ticket(capacity):
    """
    Randomly generate tickets based on plane's capacity
    """
    tickets = []
    col = 6
    rows = int(capacity/col)
    for row in range(rows):
        for col in range(1, col+1):
            ticket = Ticket(seat_number=plane_rows[row] + str(col), available=random.choice(avaliability), price=random.choice(prices))
            tickets.append(ticket)

    return tickets


def generate_random_flight_dates(num_flights):
    """
    Randomly generate departing datetime and arriving datetime for flights
    :param num_flights  Number of flights
    :return Random flight dates
    """
    departure_datetimes = []
    arrival_datetimes = []
    flight_duration = [d for d in range(1, 5, 1)] # duration from 1 - 4 days
    # Mapping from month to the number of days. Ignore leap year for simplicity
    month_to_date = {1:31, 2:28, 3:31, 4:30, 5:31, 6:30, 7:31, 8:31, 9:30, 10:31, 11:30, 12:31}
    minutes = [minute for minute in range(0, 60, 5)]
    now = datetime.datetime.now()
    for i in range(num_flights):
        departure_hour = random.randint(1, 23)
        departure_minute = random.choice(minutes)
        # date start from 11-01-2017.
        # TODO: This is for testing purpose to match with other services. Might consider start from current date
        departure_month = random.randint(11, 12)
        departure_day = random.randint(1, month_to_date[departure_month])
        departure_year = now.year
        departure_datetime = datetime.datetime(departure_year, departure_month, departure_day, departure_hour,
                                               departure_minute, 0)

        arrival_hour = random.randint(1, 23)
        arrival_minute = random.choice(minutes)
        arrival_day = departure_day + random.choice(flight_duration)

        if arrival_day <= month_to_date[departure_month]:
            arrival_month = departure_month
            arrival_year = departure_year
        else:
            arrival_day = arrival_day - month_to_date[departure_month]
            arrival_month = departure_month + 1 if departure_month < 12 else 1
            if arrival_month == 1:
                arrival_year = departure_year + 1
            else:
                arrival_year = departure_year

        arrival_datetime = datetime.datetime(arrival_year, arrival_month, arrival_day, arrival_hour, arrival_minute, 0)

        departure_datetimes.append(departure_datetime)
        arrival_datetimes.append(arrival_datetime)

    return departure_datetimes, arrival_datetimes
