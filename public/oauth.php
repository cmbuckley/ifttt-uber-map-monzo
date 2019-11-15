<?php

require_once '../vendor/autoload.php';

use Starsquare\Monzo\Provider;

$file = '../config/oauth.json';
$config = json_decode(file_get_contents($file), true);
session_start();

$provider = new Provider([
    'baseAuthorizationUrl' => 'https://auth.monzo.com/',
    'clientId'     => $config['client_id'],
    'clientSecret' => $config['client_secret'],
    'redirectUri'  => 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
]);

// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Now you can do something useful with the access token.
    var_dump($token);

    // Optional: Store the token in the session so we can refresh the page while we're testing
    $config['access_token'] = [
        'access_token'      => $token->getToken(),
        'expires'           => $token->getExpires(),
        'refresh_token'     => $token->getRefreshToken(),
        'resource_owner_id' => $token->getResourceOwnerId()
    ];

	file_put_contents($file, json_encode($config, JSON_PRETTY_PRINT));
}
