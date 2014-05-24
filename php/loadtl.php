<?php

include('connect.php');
$mysqli = connect();

if ($result = $mysqli->query("SELECT * FROM timelines WHERE id_tl = 1")) {
	$data = $result->fetch_array();
	echo json_encode($data);
}

?>
