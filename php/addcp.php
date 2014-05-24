<?php
include('connect.php');
$mysqli = connect();

if (isset($_POST['submit']))
{
	if (isset($_POST['name']) && isset($_POST['date']))
	{
		if (!($stmt = $mysqli->prepare("INSERT INTO cp VALUES (?,?,?)"))) {
			    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if (!$stmt->bind_param("sss", $_POST['name'], $_POST['date'], $_SESSION['id'])) {
			    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
	}
}

?>
