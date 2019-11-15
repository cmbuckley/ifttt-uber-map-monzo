<?php

function error($code, $message, $header = ' ') {
    header($header, true, $code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('message' => $message), JSON_PRETTY_PRINT);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    error(405, 'You must POST to this API', 'Allow: POST');
}

if (!isset($_SERVER['PHP_AUTH_USER']) || md5($_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW']) != 'bc2da2ce08c3ed97e228c744ca97fb86') {
    error(401, 'You must use Basic authentication with this API', 'WWW-Authenticate: Basic realm="ifttt-uber-monzo"');
}

if (!isset($_POST['TripMapImage'])) {
    error(400, 'You must supply a TripMapImage URL');
}

file_put_contents(tempnam('/tmp', 'ifttt-uber-monzo'), json_encode($_POST));
