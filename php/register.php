<?php
session_start();
include('connect.php');
require_once ('../vendor/autoload.php');

$mysqli = connect();

if (isset($_POST['login'], $_POST['password'], $_POST['passagain']))
{
    if ($_POST['password'] == $_POST['passagain'])
    {
        if (!($stmt = $mysqli->prepare("INSERT INTO users(name, password) VALUES (?,?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("ss", $_POST['name'], hash('whirlpool', $_POST['password']))) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $_SESSION['data'] = array($_POST['login'], $_POST['password']);
        header('Location: ../wip.php');
    }
    else
        header('Location: ../index.php?msg=error');
}
