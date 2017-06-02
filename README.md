Booking Guru API v1
===================

Welcome to the Booking Guru API, we're glad you could make it. Let's poke around a bit.

And just in case you have no idea where you are, [Booking Guru](http://bookingsoftware.guru)
is a software package for spiritual retreat centers to manage programs, registrations, finances
and everything in between.

## Security token

The first thing you'll need is the security token for your installation. Go to the Reg. Settings
on your install, select the API tab and grab the token that appears there.

![](resource/token.png "Where is my token?")

If there isn't a token there yet, hit *Generate Token*, then *Save changes* and then copy the token.

Set a couple of environment variables so it's easier to run the samples:

```
$ export BGDOMAIN=<domain>
$ export BGTOKEN=<token>
```

The `<domain>` is your install's domain, and `<token>` is the token you just got from the admin UI.

Lets take a look at some data.

## Curl examples

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

## API Reference

Following is the reference for the requests you can currently do against the API.

All values with the `date` type are in `YYYY-MM-DD` format, all values with the `date-time` type are in the `YYYY-MM-DDTHH:MM:SS` format.

---

### GET /programs
**Get program info**

Retrieves information about programs, their dates and and categories.

#### Parameters

**`token: string [required]`**
>Security token

**`limit: integer`**
>Limit number of return values. The default limit is 20. Pass `limit=0` To get all the programs without limits, but please use this with caution to not overload our servers. 

**`id: [integer]`**
>Gets programs with a specific id or list of ids. To get multiple objects, provide a comma separated list of values. 

#### Responses

| Code | Description | Schema |
| ---- | ----------- | ------ |
200 | An array of programs | [ [Program](#definitions-Program) ] 
400 | An error | [Error](#definitions-Error) 

---

### GET /registrations
**Get registration info**

Retrieves registration details including names, emails and programs people have registered to. Registrations are always sorted 
in reverse chronological order with the newest registrations are at the top or the result list.

#### Parameters

**`token: string [required]`**
>Security token

**`limit: integer`**
>Limit number of return values. The default limit is 20. Pass `limit=0` To get all the registrations without limits, but please use this with caution to not overload our servers. 

**`id: [integer]`**
>Gets registrations with a specific id or list of ids. To get multiple objects, provide a comma separated list of values. 

**`program_id: integer`**
>Gets all the registrations for a particular program unique id. You can find the id in the program list  of your Booking Guru admin interface in the ID column. 

**`min_date: date`**
>Gets registrations that were submitted on or after `min_date`. Can be combined with `max_date` for a range of dates. 

**`max_date: date`**
>Gets registrations that were submitted on or before `max_date`. 

**`min_stay: date`**
>Gets all registrations for which the registration stay dates are on or after `min_stay`. In particular this includes registrations that start on `min_stay`, those that start before `min_stay` and end on or after it, and those that start after `min_stay`. This will not include registrations that end before `min_stay`. 

**`max_stay: date`**
>Gets all registrations for which the registration stay dates are on or before `max_stay`. In particular this includes registrations that those that start before `max_stay` and end on or after it, and those that start after `max_stay`. This will not include registrations that start after `max_stay`. 

#### Responses

| Code | Description | Schema |
| ---- | ----------- | ------ |
200 | An array of registrations | [ [Registration](#definitions-Registration) ] 
400 | An error | [Error](#definitions-Error) 

## Models
<a name='definitions-Program'></a>

### Program

A single program

#### Properties

| Name | Type | Description |
| ---- |----- | ----------- |
| id | integer | internal unique id |
| self_url | url | API URL pointing back to the object |
| name | string | program name |
| start_date | string | program start date |
| end_date | string | program end date |
| registrations_url | string | API URL for program registrations |
| transactions_url | string | API URL for program transactions |
| teachers | [string] | teacher names for the program |
<a name='definitions-Registration'></a>

### Registration

A single registration by a guest to a program.

#### Properties

| Name | Type | Description |
| ---- |----- | ----------- |
| id | integer | internal unique id |
| self_url | url | API URL pointing back to the object |
| submitted | date-time | time the registration was submitted |
| start_date | date | the day the guest's stay starts |
| end_date | date | the day the guest's stay ends |
| status | string | registration status [pending, reserved, cancelled, etc...] |
| first_name | string | guest's first name |
| last_name | string | guest's last name |
| full_name | string | guest's full name |
| email | email | guest's email address |
| program | string | name of program the registration is for |
| program_url | url | URL for API representation of program |
| program_categories | [string] | categories for the program |
| transactions_url | url | API URL for registration's transactions |
| optional_items | [string] | optional items (add-ons) selected for the registration |
| room | string | name of room guest will be staying in |
| lodging | string | name of lodging type selected |
| nights | integer | total nights of stay |
| grand_total | decimal | total amount owed for the registration |
| balance_due | decimal | current balance |
| guest_statement_link | url | link to the (user-facing) guest statement |
| guest_edit_link | url | link to guest edit page (where a guest can update their details) |
<a name='definitions-Error'></a>

### Error

An error returned in case of an incorrect request.

#### Properties

| Name | Type | Description |
| ---- |----- | ----------- |
| message | string | description of error and steps to correct it |
