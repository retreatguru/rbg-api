#!/usr/bin/env python3
#
# This script lists all the programs available for a retreat center.
# 
# To run it you need to have the RGDOMAIN and RGTOKEN environment variables
# properly configured sa explained in the README.md file.

import os
import json
from urllib import request

# get the environment variables
domain = os.getenv('RGDOMAIN')
token = os.getenv('RGTOKEN')

# create the url to access the data on the API
url = 'http://{domain}/api/v1/programs?token={token}'.format(domain=domain, token=token)

# access the API and parse the JSON response
with request.urlopen(url) as response:
    data = json.loads(response.read().decode('utf8'))

# print the names and dates of the programs
for program in data:
    print('{name} (from {start_date} to {end_date})'.format(
        name=program['name'],
        start_date=program['start_date'],
        end_date=program['end_date'],
    ))
