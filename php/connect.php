<?php
function connect()
{
	$mysqli = new mysqli('localhost', 'root', 'password', 'wip');

	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') '
			. $mysqli->connect_error);
	}
	return ($mysqli);
}
?>
