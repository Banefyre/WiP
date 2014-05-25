<?php

include('php/header.php');
echo "<body>";
include('php/menu.php');

$id_timeline = 1;

$mysql = connect();
$res = $mysql->query("SELECT * FROM checkpoint WHERE id_timeline = ".$id_timeline);
$res = $res->fetch_array();


$date = date_create_from_format("Y-m-d\TH:i:sO", $date);
    $begin = date_create_from_format("Y-m-d\TH:i:sO", $begin);
?>
