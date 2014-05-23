<?php

require_once 'vendor/autoload.php';

$client = new \Github\Client();

$client->authenticate('', '', Github\Client::AUTH_HTTP_PASSWORD);

$repositories = $client->api('user')->repositories('Kerumen');
