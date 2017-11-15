from flask import Flask
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:////tmp/test.db'
db = SQLAlchemy(app)


class Flights(db.Model):
    flightID = db.Column(db.Integer, primary_key=True, autoincrement=True)
    userName = db.Column(db.String(120), unique=False, nullable=False)
    totalSeats = db.Column(db.Integer, unique=False, nullable=False)
    ticketQuantity = db.Column(db.Integer, unique=False, nullable=False)

class Tickets(db.Model):
    ticketID = db.Column(db.Integer, primary_key=True, autoincrement=True)
    flightID = db.Column(db.Integer, db.ForeignKey('Flights.flightID'), nullable=False)
    ticketPrice = db.Column(db.Float, unique=False, nullable=False)

class DepartingLocation(db.Model):
    ID = db.Column(db.Integer, primary_key=True, autoincrement=True)
    flightID = db.Column(db.Integer, db.ForeignKey('Flights.flightID'), nullable=False)
    departingCity = db.Column(db.String(120), unique=False, nullable=False)
    departingState = db.Column(db.String(120), unique=False, nullable=False)
    departingCountry = db.Column(db.String(120), unique=False, nullable=False)
    departingZipcode = db.Column(db.Integer, unique=False, nullable=False)
    departingAirport = db.Column(db.String(120), unique=False, nullable=False)

class DestinationLocation(db.Model):
    ID = db.Column(db.Integer, primary_key=True, autoincrement=True)
    flightID = db.Column(db.Integer, db.ForeignKey('Flights.flightID'), nullable=False)
    destinationCity = db.Column(db.String(120), unique=False, nullable=False)
    destinationState = db.Column(db.String(120), unique=False, nullable=False)
    destinationCountry = db.Column(db.String(120), unique=False, nullable=False)
    destinationZipcode = db.Column(db.Integer, unique=False, nullable=False)
    destinationAirport = db.Column(db.String(120), unique=False, nullable=False)

class PurchaseHistory(db.Model):
    onrderNumber = db.Column(db.Integer, primary_key=True, autoincrement=True)
    ticketID = db.Column(db.Integer, db.ForeignKey('Tickets.ticketID'), nullable=False)
    name = db.Column(db.String(120), unique=False, nullable=False)
    username = db.Column(db.String(120), unique=False, nullable=False)

def main():
    db.create_all()

main
