<?php

// get the environment variables
$domain = getenv('RGDOMAIN');
$token = getenv('RGTOKEN');

if (! ($domain || $token)) {
    echo "error: please set RGDOMAIN and RGTOKEN\n";
    exit(1);
}

// create the url to access the data on the API
$url = "http://$domain/api/v1/programs?token=$token";

// access the API and parse the JSON response
$response = file_get_contents($url);
$programs = json_decode($response);

// print the names and dates of the programs
foreach ($programs as $program) {
    echo "$program->name (from $program->start_date to $program->end_date)\n";
}

