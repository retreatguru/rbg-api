<?php

// get the environment variables
$domain = getenv('RGDOMAIN');
$token = getenv('RGTOKEN');

# get all the registrations
$page = 1;
while (true) {
    // create the url to access the data on the API
    // use a page size (limit) of 10 and get one page at a time
    $url = "http://$domain/api/v1/registrations?token=$token&limit=10&page=$page";

    // access the API and parse the JSON response
    $response = file_get_contents($url);
    $registrations = json_decode($response);

    // if we got an empty list that means we are at the last page\
    if (empty($registrations)) {
        break;
    }

    // print the names and dates of the registrations
    foreach ($registrations as $registration) {
        echo "$registration->full_name (from $registration->start_date to $registration->end_date)\n";
    }

    // get next page
    $page++;
}
