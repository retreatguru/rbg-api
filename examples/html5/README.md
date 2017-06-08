HTML/JS example
===============

In order to protect the token, we're using a simple PHP proxy with a hardcoded token that remains on the server to serve the REST API. This is of course a toy example. Properly securing a web application is hard and is outside of our scope here.

Use the following commands to run the example locally:

    $ export RGDOMAIN=<domain>
    $ export RGTOKEN=<token>
    $ php -S localhost:8080 proxy.php

And go to http://localhost:8080.