<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Kemlu\OAuth2\Client\Provider\Kemlu;
//require dirname(__DIR__, 1).'/oauth2-client/src/Provider/Kemlu.php';



session_start(); // Remove if session.auto_start=1 in php.ini

$provider = new Kemlu([
    'verify' => false,
    'clientId'     => '5f2ee8dd4dfd62c9c299166494174941',
    'clientSecret' => '43141551e506ac8a4ba3f85bd262ae4e2617181188a39a24c99696c8d456c3cf78cfd4fbcfa2a8263af140d54c099e7b4b9ea8dcaaeae26e3b93111a34ee814f',
    'redirectUri'  => 'https://localhost:8001/index.php',
    //'prompt' => 'none' #uncomment ini biar g usah ada user consent
], [
    'httpClient'
]);

$provider->setIdentityUrl("https://localhost:8000");

$guzzyClient = new GuzzleHttp\Client([
    'defaults' => [
        \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => 5,
        \GuzzleHttp\RequestOptions::ALLOW_REDIRECTS => true],
        \GuzzleHttp\RequestOptions::VERIFY => false,
        \GuzzleHttp\RequestOptions::HEADERS => ["Accept" =>"application/json"],
]);

$provider->setHttpClient($guzzyClient);

if (!empty($_GET['error'])) {

    // Got an error, probably user denied access
    exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));

} elseif (empty($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;

} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    // State is invalid, possible CSRF attack in progress
    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);


    var_dump($token);


    print_r($token->getToken());

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the owner details
        $ownerDetails = $provider->getResourceOwner($token);

        var_dump($ownerDetails);
        //exit;

        // Use these details to create a new profile
        // printf('Hello %s!', $ownerDetails->getFirstName());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Something went wrong: ' . $e->getMessage());

    }

    // Use this to interact with an API on the users behalf
    echo "<br> TOKEN <br>";
    echo $token->getToken();
    echo "<br> END- TOKEN <br>";
    // Use this to get a new access token if the old one expires
    echo $token->getRefreshToken();

    // Unix timestamp at which the access token expires
    echo $token->getExpires();
}
