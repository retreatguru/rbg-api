<?php

// This script redirects all calls to itself to the API server configured
// in the RGDOMAIN and RGTOKEN environment variables.
// 
// To run it locally, use:
// 
// $ php -S localhost:8080 proxy.php

if (! preg_match('#^/api/#', $_SERVER["REQUEST_URI"])) {
    // if path doesn't start with /api/, serve the file directly
    return false;
}

// get parameters from environment
$domain = getenv('RGDOMAIN');
$token = getenv('RGTOKEN');

// parse url
$parsed = parse_url("$_SERVER[REQUEST_URI]");
if (isset($parsed['query'])) {
    parse_str($parsed['query'], $parsed['query']);
} else {
    $parsed['query'] = [];
}

// build new API url
$query['token'] = $token;
$query = http_build_query($query);
$url = "http://$domain$parsed[path]?$query";

// call the API and return the result
echo file_get_contents($url);
