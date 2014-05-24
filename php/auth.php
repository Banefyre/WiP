<?php
session_start();
include('connect.php');
require_once ('../vendor/autoload.php');

$mysqli = connect();

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
    {
        $_SESSION['data'] = array($_POST['login'], $_POST['password']);

        if (!($stmt = $mysqli->prepare("INSERT INTO users SET login='".$_POST['login']."', password='".hash("whirlpool", $_POST['password'])."'"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        header('Location: ../wip.php');
    }
    else
        header('Location: ../index.php?msg=error');
}
