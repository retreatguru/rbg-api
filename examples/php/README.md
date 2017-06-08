PHP example
===========

Before you run the scripts, set up the environment variables:

    $ export RGDOMAIN=<domain>
    $ export RGTOKEN=<token>

**programs.php**

This simple script connects to the API and gets the list of programs (only 20 of them, which is the default page size).

    $ php programs.php

**pages.hp**

This script shows how to get all the registrations by using paging.

    $ php pages.php
