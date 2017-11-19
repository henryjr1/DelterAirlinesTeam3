# util.py

import string
import random
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
