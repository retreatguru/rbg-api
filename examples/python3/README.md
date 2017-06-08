Python 3 example
================

Before you run the scripts, set up the environment variables:

    $ export RGDOMAIN=<domain>
    $ export RGTOKEN=<token>

**programs.py**

This simple script connects to the API and gets the list of programs (only 20 of them, which is the default page size).

    $ python3 programs.py

**pages.py**

This script shows how to get all the registrations by using paging.

    $ python3 pages.py
