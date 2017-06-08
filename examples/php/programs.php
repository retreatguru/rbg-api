<?php

// This script lists all the programs available for a retreat center.
// 
// To run it you need to have the RGDOMAIN and RGTOKEN environment variables
// properly configured sa explained in the README.md file.

$domain = getenv('RGDOMAIN');
$token = getenv('RGTOKEN');
$url = "http://$domain/api/v1/programs?token=$token";

$response = file_get_contents($url);
$programs = json_decode($response);

foreach ($programs as $program) {
    echo "$program->name (from $program->start_date to $program->end_date)\n";
}

