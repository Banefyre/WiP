<?php
function connect()
{
	$mysqli = new mysqli('localhost', 'root', '', 'wip');

	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') '
			. $mysqli->connect_error);
	}
	return ($mysqli);
}
?>
