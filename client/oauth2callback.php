<?php

require '../vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setApplicationName('Google Calendar API Integration');
$client->setScopes(Google_Service_Calendar::CALENDAR);
$client->setAuthConfig('credentials.json'); // Path to your credentials file
$client->setRedirectUri('http://localhost/oauth2callback.php');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
    header('Location: http://localhost'); // Redirect to your main page
    exit();
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
}
