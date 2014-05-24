<?php
session_start();
include('connect.php');
require_once ('../vendor/autoload.php');

if (isset($_POST['login']))
{
    $data = $_SESSION['data'];
    $client = new \Github\Client();
    $client->authenticate($data[0], $data[1], Github\Client::AUTH_HTTP_PASSWORD);

    $user = $client->api('user')->find($_POST['login']);
    echo(json_encode($user['users']));
}
?>
