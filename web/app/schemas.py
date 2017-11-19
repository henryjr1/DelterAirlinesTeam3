from marshmallow import Schema, fields


class PassengerSchema(Schema):
    # id = fields.Int()
    # name = fields.Str()
    # dob = fields.DateTime()
    # email = fields.Email()
    # address = fields.Str()

    class Meta:
        fields = ("id", "name", "dob", "email", "address")
        ordered = True


class TicketSchema(Schema):
    id = fields.Int()
    seat_number = fields.Str()
    available = fields.Bool()
    plane_id = fields.Int()

    # class Meta:
    #     fields = ("id", "seat_number", "available", "plane_id")
    #     ordered = True


class PlaneSchema(Schema):
    id = fields.Int()
    model = fields.Str()
    capacity = fields.Int()
    flight_number = fields.Str()
    tickets = fields.Nested(TicketSchema, only=["id", "seat_number", "available"])

    class Meta:
        # fields = ("id", "model", "capacity", "flight_number")
        ordered = True


class FlightSchema(Schema):
    id = fields.Int()
    fromLocation = fields.Str(attribute="source")
    toLocation = fields.Str(attribute="destination")
    # plane_id = fields.Int()
    plane = fields.Nested(PlaneSchema)
    startDate = fields.DateTime(attribute="departure_time")
    endDate = fields.DateTime(attribute="arrival_time")
    locale = fields.DateTime()

    class Meta:
        # fields = ("id", "source", "destination", "plane", "departure_time", "arrival_time", "locale")
        ordered = True

