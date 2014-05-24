<?php

require_once '../vendor/autoload.php';
session_start();

if (isset($_POST['login'], $_POST['password']))
{
    $caught = false;
    $client = new \Github\Client();

    $client->authenticate($_POST['login'], $_POST['password'], Github\Client::AUTH_HTTP_PASSWORD);

    try
    {
        $client->api('authorizations')->all();
    }
    catch (RuntimeException $e)
    {
        $caught = true;
    }
    if (!$caught)
        header('Location: ../wip.html');
    else
        header('Location: ../index.php?msg=error');
}
