<?php
require_once '../vendor/autoload.php';

// Hata ayıklama modunu aç
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Google OAuth yapılandırmasını yükle
$config = require_once 'google_config.php';

// Google istemcisini oluştur
$client = new Google\Client();
$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);
$client->addScope($config['scopes']);

// Her zaman hesap seçim ekranını göster
$client->setPrompt('select_account consent');

// Kimlik doğrulama URL'sini oluştur ve yönlendir
$auth_url = $client->createAuthUrl();
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
exit; 