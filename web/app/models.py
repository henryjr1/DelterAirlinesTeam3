# models.py

from app import db

class Passenger(db.Model):
    __tablename__ = "passengers"

    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(30), nullable=False)
    dob = db.Column(db.Date, nullable=False)
    email = db.Column(db.String(30), unique=True, nullable=False)
    address = db.Column(db.Text, nullable=False)

    def __repr__(self):
        return '<name {}>'.format(self.name)


class Plane(db.Model):
    __tablename__ = "planes"

    id = db.Column(db.Integer, primary_key=True)
    model = db.Column(db.String(30), unique=True, nullable=False)
    capacity = db.Column(db.Integer, nullable=False)
    flight_number = db.Column(db.String(30), unique=True, nullable=False)

    def __repr__(self):
        return '<model = {} --- capacity = {} --- flight number = {}>'.format(self.model, self.capacity, self.flight_number)


class Flight(db.Model):
    __tablename__ = 'flights'

    id = db.Column(db.Integer, primary_key=True)
    source = db.Column(db.String(200), nullable=False)
    destination = db.Column(db.String(200), nullable=False)
    plane_id = db.Column(db.Integer, db.ForeignKey('planes.id'))
    plane = db.relationship("Plane", backref=db.backref('flights', lazy=True))
    departure_time = db.Column(db.DateTime, nullable=False)
    departure_zip_code = db.Column(db.Integer, nullable=False)
    arrival_time = db.Column(db.DateTime, nullable=False)
    arrival_zip_code = db.Column(db.Integer, nullable=False)
    locale = db.Column(db.String(50), nullable=False)
    tickets = db.relationship("Ticket", backref="flights", lazy="dynamic")


class Ticket(db.Model):
    __tablename__ = 'tickets'

    id = db.Column(db.Integer, primary_key=True)
    seat_number = db.Column(db.String(4), nullable=False)
    price = db.Column(db.Float, nullable=False)
    available = db.Column(db.Boolean, nullable=False)
    flight_id = db.Column(db.Integer, db.ForeignKey('flights.id'), nullable=False)
    flight = db.relationship("Flight")

    def __repr__(self):
        return '<seat_number = {} --- available = {} ----'.format(self.seat_number, self.available)


class AirFare(db.Model):
    __tablename__ = 'airfares'

    id = db.Column(db.Integer, primary_key=True)
    amount = db.Column(db.Numeric, nullable=False)
    description = db.Column(db.String(100), nullable=True)


class Transaction(db.Model):
    __tablename__ = 'transactions'

    id = db.Column(db.Integer, primary_key=True)
    # booking_date_time = db.Column(db.DateTime, nullable=False)

    passenger_id = db.Column(db.Integer, db.ForeignKey('passengers.id'))
    passenger = db.relationship('Passenger', backref='transactions')

    ticket_id = db.Column(db.Integer, db.ForeignKey('tickets.id'))
    ticket = db.relationship('Ticket', backref='transactions')

    # airfare_id = db.Column(db.Integer, db.ForeignKey('airfares.id'))
    # airfare = db.relationship('AirFare', backref='transactions')
