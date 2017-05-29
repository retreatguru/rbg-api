# Booking Guru API docs v1
`https://{domain}.secure.retreat.guru/api/{version}`

## About
This is the API definition for Booking Guru, and online software package
designed for retreat centers to manage bookings, retreats, rooms and
finances. The API allows access to programs, registrations and transactions
that are stored within the system to allow integration with custom software.
The same API is also used in our Zapier integration that allows connecting
Booking Guru to other applications without the need for custom code.

---

## /registrations

### GET
Registration details including names, emails and programs people have registered to. Registrations are always sorted 
in reverse chronological order with the newest registations are at the top or the result list.

** Parameters **

* `token (string)` - Security token

* `limit (integer)` - Limit number of return values. The default limit is 20. Pass `limit=0` To get all the registrations without limits, but please use this with caution to not overload our servers. 

* `id (array)` - Gets registrations with a specific id or list of ids. To get multiple objects, provide a comma separated list of values. 

* `min_date (date-only)` - Gets registrations that were submitted on or after `min_date`. Can be combined with `max_date` for a range of dates. 

* `max_date (date-only)` - Gets registrations that were submitted on or before `max_date`. 

* `min_stay (date-only)` - Gets all registrations for which the registration stay dates are on or after `min_stay`. In particular this includes registrations that start on `min_stay`, those that start before `min_stay` and end on or after it, and those that start after `min_stay`. This will not include registrations that end before `min_stay`. 

* `max_stay (date-only)` - Gets all registrations for which the registration stay dates are on or before `max_stay`. In particular this includes registrations that those that start before `max_stay` and end on or after it, and those that start after `max_stay`. This will not include registrations that start after `max_stay`. 

* `program_id (integer)` - Gets all the registrations for a particular program unique id. You can find the id in the program list  of your Booking Guru admin interface in the ID column. 

* `program_slug (string)` - Filter registrations by  

* `nocache (string)` - Filter registrations by  

** Responses **

* 200 - An array of registration objects.
    
    * `id (integer)` - registration id
    
    * `first_name (string)` - 
    
    * `last_name (string)` - 
    
    * `start_date (date-only)` - 
    
    * `end_date (date-only)` - 
    
    * `submitted (datetime)` - 
    
* 400 - An error message about an incorrectly submitted request. Includes deatils about the problem and (often) steps to follow to correct it. 
    
    * `message (string)` - 
    

