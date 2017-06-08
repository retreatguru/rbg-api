import os
import sys
import json
from urllib import request

# get the environment variables
domain = os.getenv('RGDOMAIN')
token = os.getenv('RGTOKEN')

if (not (domain and token)):
    print("error: please set RGDOMAIN and RGTOKEN")
    sys.exit(1)

# get all the registrations
page = 1
while True:
    # create the url to access the data on the API
    # use a page size (limit) of 10 and get one page at a time
    url = 'http://{domain}/api/v1/registrations?token={token}&limit=10&page={page}'.format(domain=domain, token=token, page=page)

    # access the API and parse the JSON response
    with request.urlopen(url) as response:
        data = json.loads(response.read().decode('utf8'))

    # if we got an empty list that means we are at the last page
    if not data:
        break

    # print the names and dates of the registrations
    for registration in data:
        print('{name} (from {start_date} to {end_date})'.format(
            name=registration['full_name'],
            start_date=registration['start_date'],
            end_date=registration['end_date'],
        ))

    # get next page
    page += 1
