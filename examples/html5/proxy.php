<?php

if (! getenv('RGDOMAIN')) {
    echo "error: environment variables RGDOMAIN and RGTOKEN not set\n";
    exit(1);
}

// if process the request if it starts with /api/ otherwise serve the file directly
if (! preg_match('#^/api/#', $_SERVER["REQUEST_URI"])) {
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
$data = file_get_contents($url);

// remove tokens from all the URLs in the result
$data = preg_replace("/[&?]token=$token/", '', $data);
$data = str_replace($token, '', $data);

// replace all URLs with proxy path
$data = str_replace("$domain/api", "$_SERVER[HTTP_HOST]/api", $data);

// send result back to client
echo $data;
