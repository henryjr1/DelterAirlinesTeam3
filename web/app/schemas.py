from marshmallow import Schema, fields

DATE_TIME_FORMAT = '%Y-%m-%dT%H:%M:%S'

class PassengerSchema(Schema):
    id = fields.Int()
    name = fields.Str()
    dob = fields.DateTime()
    email = fields.Email()
    address = fields.Str()

    class Meta:
        ordered = True


class TicketSchema(Schema):
    id = fields.Int()
    seat_number = fields.Str()
    price = fields.Float()
    available = fields.Bool()
    flight_id = fields.Int()

    class Meta:
        ordered = True


class PlaneSchema(Schema):
    id = fields.Int()
    model = fields.Str()
    capacity = fields.Int()
    flight_number = fields.Str()

    class Meta:
        ordered = True


class FlightSchema(Schema):
    id = fields.Int()
    fromLocation = fields.Str(attribute="source")
    toLocation = fields.Str(attribute="destination")
    # plane_id = fields.Int()
    plane = fields.Nested(PlaneSchema)
    startDate = fields.DateTime(attribute="departure_time", format=DATE_TIME_FORMAT)
    endDate = fields.DateTime(attribute="arrival_time", format=DATE_TIME_FORMAT)
    departingZipCode = fields.DateTime(attribute="departure_zip_code")
    arrivingZipCode = fields.DateTime(attribute="arrival_zip_code")
    locale = fields.DateTime()
    tickets = fields.Nested(TicketSchema, many=True, only=["id", "seat_number", "price", "available"])

    class Meta:
        ordered = True

class TransactionSchema(Schema):
    passenger = fields.Nested(PassengerSchema)
    ticket = fields.Nested(TicketSchema)

    class Meta:
        ordered = True
