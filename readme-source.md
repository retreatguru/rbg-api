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

