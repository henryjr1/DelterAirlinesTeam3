# util.py

import string
import random
from app.models import Ticket

plane_rows = string.ascii_uppercase
avaliability = [True, False]

def generate_random_ticket(capacity):
    """
    Randomly generate tickets based on plane's capacity
    """
    tickets = []
    col = 6
    rows = int(capacity/col)
    for row in range(rows):
        for col in range(1, col+1):
            ticket = Ticket(seat_number=plane_rows[row] + str(col), available=random.choice(avaliability))
            tickets.append(ticket)

    return tickets
