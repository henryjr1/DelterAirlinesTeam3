from flask_wtf import FlaskForm
from wtforms import StringField, DateField
from wtforms.validators import DataRequired, Length, EqualTo, Email


class PlaceOrderForm(FlaskForm):
    '''
    first_name = StringField('FirstName', validators=[DataRequired(), Email(), Length(min=6, max=40)])
    password = PasswordField('Password', validators=[DataRequired(), Length(min=6, max=40)])
    confirm = PasswordField('Repeat Password', validators=[DataRequired(), EqualTo('password')])
    '''
    first_name = StringField('FirstName', validators=[DataRequired(), Length(max=40)])
    last_name = StringField('LastName', validators=[DataRequired(), Length(max=40)])
    email = StringField('Email', validators=[DataRequired(), Email(), Length(min=6, max=40)])
    address = StringField('Address', validators=[DataRequired(), Length(max=100)])


class FlightSearchForm(FlaskForm):
    """
    Flight search form
    """
    flying_from = StringField('From', validators=[DataRequired(), Length(max=40)])
    flying_to = StringField('To', validators=[DataRequired(), Length(max=40)])
    departure_date = DateField('DepartureDate', validators=[DataRequired()])
    arrival_date = DateField('ArrivalDate', validators=[DataRequired()])