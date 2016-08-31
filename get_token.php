<?php

if (php_sapi_name() != 'cli') {
	header('HTTP/1.0 404 Not Found');
	die('404 - Not Found');
}

$config = include __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

$client = \Mkkp\Enemy\Google\ServiceFactory::createClient($config['spreadsheet']['app_secret']);
printf('Open auth urL:' . PHP_EOL . '%s' . PHP_EOL, $client->createAuthUrl());

print 'Verification code: ';
$authCode = trim(fgets(STDIN));

$token = $client->fetchAccessTokenWithAuthCode($authCode);

\Mkkp\Enemy\Google\ServiceFactory::saveToken($config['spreadsheet']['token_file'], $token);
printf('Token saved to: %s'.PHP_EOL, $config['spreadsheet']['token_file']);