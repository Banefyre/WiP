<?php
session_start();
include('connect.php');
require_once ('../vendor/autoload.php');

if (isset($_POST['repo']))
{
    $data = $_SESSION['data'];

    $client = new \Github\Client();
    $client->authenticate($data[0], $data[1], Github\Client::AUTH_HTTP_PASSWORD);

    $repo = $_POST['repo'];
    if (!empty($_POST['login']))
        $username = $_POST['login'];
    else
        $username = $data[0];

    $repo = $client->api('repo')->show($username, $repo);

    $mysqli = connect();

    $query = $mysqli->query("SELECT * FROM timeline WHERE name='".$repo['name']."'");
    $query = $query->fetch_array();

    if ($query == NULL)
    {
        if (!($stmt = $mysqli->prepare("INSERT INTO timeline(author, name) VALUES (?,?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("ss", $username, $repo['name'])) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $id_timeline = $mysqli->insert_id;
        $id = $mysqli->query("SELECT id FROM users WHERE login='".$data[0]."'");
        $id = $id->fetch_array();

        if (!($stmt = $mysqli->prepare("INSERT INTO timeline_user(id_user, id_timeline) VALUES (?,?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("ii", $id['id'], $id_timeline)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
    else
    {
        $id_timeline = $query['id'];
        $id = $mysqli->query("SELECT id FROM users WHERE login='".$data[0]."'");
        $id = $id->fetch_array();

        if (!($stmt = $mysqli->prepare("INSERT INTO timeline_user(id_user, id_timeline) VALUES (?,?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("ii", $id['id'], $id_timeline)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
    //echo json_encode($query);
}
