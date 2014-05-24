<?php
session_start();
include('connect.php');
require_once ('../vendor/autoload.php');

$data = $_SESSION['data'];

$client = new \Github\Client();
$client->authenticate($data[0], $data[1], Github\Client::AUTH_HTTP_PASSWORD);

//echo $_POST['author'];

$repo = $client->api('repo')->update($_POST['author'], $_POST['oldname'], array('description' => $_POST['description']));
