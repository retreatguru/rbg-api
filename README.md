# Booking Guru API docs and samples

Hi there!

Welcome to the Booking Guru API, we're glad you could make it. Let's poke around a bit.

And just in case you have no idea where you are, [Booking Guru](http://bookingsoftware.guru) is a software package for spiritual retreat centers to manage programs, registrations, finances and everything in between.

The full API is listed below and is also available here:

https://rawgit.com/retreatguru/rbg-api/master/api.html

## Token

The first thing you'll need is the security token for your installation. Go to the Reg.Settings on your install, select the API tab and grab the token that appears there.

![](resource/token.png "Where is my token?")


If there isn't a token there yet, hit *Generate Token*, then *Save changes* and then copy the token.

Set a couple of environment variables so it's easier to run the samples:

```
$ export BGDOMAIN=<domain>
$ export BGTOKEN=<token>
```

The `<domain>` is your install's domain, and `<token>` is the token you just got from the admin UI.

Lets take a look at some data.

## CURL examples

Get latest 20 programs:

```
$ curl "https://$BGDOMAIN/api/v1/programs?token=$BGTOKEN"
```

Get latest 20 registrations:

```
$ curl "https://$BGDOMAIN/api/v1/registrations?token=$BGTOKEN"
```

Get all registrations (*dont' do this too often if you have a large install*):

```
$ curl "https://$BGDOMAIN/api/v1/registrations?token=$BGTOKEN&limit=0"
```

Get all registrations for a particular program:

```
$ curl "https://$BGDOMAIN/api/v1registrations?token=$BGTOKEN&program_slug=3-day-escape"
```

## Examples

We're working on some deeper examples in PHP, Python and Javascript that we'll push to this repo real soon.

---

# Booking Guru API docs v1
`https://{domain}.secure.retreat.guru/api/{version}`

## /registrations

### GET
Registration details including names, emails and programs people have registered to. Registrations are always sorted 
in reverse chronological order with the newest registrations are at the top or the result list.

**Parameters**

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

**Responses**

* 200 - An array of registration objects.
    
    * `email (string)` - Guest's email
    
    * `first_name (string)` - Guest's first name
    
    * `self_url (string)` - A URL pointing to the object's API representation

    
    * `balance_due (string)` - [object Object]
    
    * `subtotal_pre_tax (string)` - [object Object]
    
    * `guest_edit_link (string)` - [object Object]
    
    * `guest_statement_link (string)` - [object Object]
    
    * `program_id (string)` - [object Object]
    
    * `lodging (string)` - [object Object]
    
    * `optional_items (string)` - [object Object]
    
    * `person_id (string)` - [object Object]
    
    * `program_url (string)` - [object Object]
    
    * `program_category (string)` - [object Object]
    
    * `submitted (string)` - [object Object]
    
    * `lodging_id (string)` - [object Object]
    
    * `nights (string)` - [object Object]
    
    * `price_choice (string)` - [object Object]
    
    * `end_date (string)` - Departure date
    
    * `start_date (date-only)` - Arrival date
    
    * `status (string)` - The registation status [pending, reserved, arrived, cancelled]
    
    * `id (integer)` - Unique internal identifier of the object

    
    * `taxes_sum (string)` - [object Object]
    
    * `taxes_array (string)` - [object Object]
    
    * `grand_total (string)` - [object Object]
    
    * `transactions_url (string)` - [object Object]
    
    * `last_name (string)` - Guest's last name
    
    * `total_payments_refunds (string)` - [object Object]
    
    * `room (string)` - [object Object]
    
    * `full_name (string)` - Guest's full name
    
    * `room_id (string)` - [object Object]
    
    * `program (string)` - The name of the program
    
* 400 - An error message about an incorrectly submitted request. Includes deatils about the problem and (often) steps to correct it. 
    
    * `message (string)` - 
    

