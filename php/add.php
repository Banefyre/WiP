<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script>
		$(function() {
			$( "#datepicker" ).datepicker();
		});
	</script>
</head>
<body>

<form method="post" action="addcp.php">
<p>Name: <input type="text" name="name"></p>
<p>Date: <input type="text" id="datepicker" name="date"></p>
<input type="submit" value="Create">
</form>

</body>
</html>
